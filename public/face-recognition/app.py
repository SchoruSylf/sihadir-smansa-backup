import base64
import os
import pickle
import cv2
import numpy as np
import pandas as pd
from flask import Flask, jsonify, request
from skimage.feature import local_binary_pattern
from sklearn.metrics import DistanceMetric
from sklearn.svm import SVC

app = Flask(__name__)

# Load labels from CSV
labels_filename = "labels.csv"
labels = pd.read_csv(labels_filename, header=None, dtype=str)[0].values

class LBPH_SVM_Recognizer_V2():
    def __init__(self, C=100, Gamma=0.001):
        self.svm = SVC(kernel='precomputed', C=C, gamma=Gamma,probability=True)
        self.chi2 = DistanceMetric.get_metric('pyfunc', func=self.chi2_distance)
        self.face_histograms = []
        self.hist_mat = []
        
    def chi2_distance(self, hist1, hist2, gamma=0.5): 
        chi = - gamma * np.sum(((hist1 - hist2) ** 2) / (hist1 + hist2 + 1e-7)) 
        return chi

    def find_lbp_histogram(self, image, P=8, R=1, eps=1e-7, n_window=(8,8)):
        E = []
        h, w = image.shape
        h_sz = int(np.floor(h/n_window[0]))
        w_sz = int(np.floor(w/n_window[1]))
        lbp_img = local_binary_pattern(image, P=P, R=R, method="default")
        for (x, y, C) in self.sliding_window(lbp_img, stride=(h_sz, w_sz), window=(h_sz, w_sz)):
            if C.shape[0] != h_sz or C.shape[1] != w_sz:
                continue
            H = np.histogram(C,                          
                             bins=2**P, 
                             range=(0, 2**P),
                             density=True)[0] 
            
            H = H.astype("float")
            H /= (H.sum() + eps)
            E.extend(H)
        return E
    
    def sliding_window(self, image, stride, window):
        for y in range(0, image.shape[0], stride[0]):
            for x in range(0, image.shape[1], stride[1]):
                yield (x, y, image[y:y + window[1], x:x + window[0]])
                   
    def train(self, x, y):
        self.face_histograms = [self.find_lbp_histogram(img) for img in x]
        self.hist_mat = np.array(self.face_histograms, dtype=np.float32)
        K = self.chi2.pairwise(self.hist_mat,self.hist_mat)
        self.svm.fit(K, y)
    
    def predict(self, x):
        hists = [self.find_lbp_histogram(img) for img in x]
        hist_mat = np.array(hists, dtype=np.float32)
        K = self.chi2.pairwise(hist_mat, self.hist_mat)
        decision_values = self.svm.decision_function(K)  # Get decision function values
        confidence_scores = 1 / (1 + np.exp(-decision_values))
                
        # Obtain probabilities if SVC was initialized with probability=True
        probabilities = self.svm.predict_proba(K)  # Get probabilities for each class
        max_probabilities = np.max(probabilities, axis=1)  # Get the highest probability per prediction

        idx = self.svm.predict(K)

        return idx, max_probabilities
        # return idx, confidence_scores

# Load trained model
def read_model(filename, path=""):
    try:
        with open(os.path.join(path, filename), 'rb') as in_name:
            model = pickle.load(in_name)
            return model
    except FileNotFoundError:
        raise FileNotFoundError(f"Model file '{filename}' not found.")

model = read_model("lbph_svm_model_v2.pkl", path="")

# Load face cascade classifier
face_cascade = cv2.CascadeClassifier('haarcascades/haarcascade_frontalface_default.xml')

def decode_base64_image(base64_image):
    try:
        encoded_data = base64_image.split(',')[1]  # Remove header 'data:image/jpeg;base64,'
        nparr = np.frombuffer(base64.b64decode(encoded_data), np.uint8)
        img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)
        return img
    except Exception as e:
        print(f"Error decoding image: {e}")
        return None

@app.route('/', methods=['POST'])
def get_items():
    data = request.get_json()
    if 'image' not in data:
        return jsonify({'error': 'No image provided'}), 400
    
    base64_image = data['image']
    frame = decode_base64_image(base64_image)
    
    if frame is None:
        return jsonify({'error': 'Failed to decode image'}), 400
    
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

    # Detect faces in grayscale image
    faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=3)

    if len(faces) == 0:
        return jsonify({'error': 'No faces detected'}), 400

    results = []
    for (x, y, w, h) in faces:
        face_img = gray[y:y+h, x:x+w]
        face_img = cv2.resize(face_img, (100, 100))
        face_img = face_img.reshape(1, 100, 100)
        idx, confidence_scores = model.predict(face_img)
        
        # Get maximum confidence score
        max_confidence = np.max(confidence_scores)*100
        
        # Check if confidence is greater than 80%
        # if max_confidence > 20:
        #     # label_text = labels[idx]
        #     label_text = str(labels[idx])
        #     results.append({'label': label_text, 'confidence': float(max_confidence)})
        # else:
        #     results.append({'label': 'Not confident enough in prediction','confidence': float(max_confidence)})
        idx = int(idx[0])
    
    # Ensure idx is within the bounds of the labels list
        if idx < len(labels):
            # Access the label and ensure it's a plain string
            label_text = labels[idx]
            
            # Convert to string if necessary (usually not needed if labels are already strings)
            if isinstance(label_text, list):
                label_text = ''.join(label_text)  # Handle if label is a list of strings
            elif not isinstance(label_text, str):
                label_text = str(label_text)  # Convert to string if it's not already
            
            results.append({'label': label_text, 'confidence': float(max_confidence)})
        else:
            results.append({'label': 'Unknown label', 'confidence': float(max_confidence)})
    print(results)
    return jsonify(results), 200

if __name__ == '__main__':
    app.run(debug=True)
