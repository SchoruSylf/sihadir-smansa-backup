import os
import pickle
import cv2
import numpy as np
import pandas as pd
from skimage.feature import local_binary_pattern
from sklearn.preprocessing import LabelEncoder
from sklearn.metrics import DistanceMetric
from sklearn.svm import SVC
from flask import Flask, jsonify, request

app = Flask(__name__)

labels_filename = "labels.csv"
# labels = pd.read_csv(labels_filename,header=None)['0'].values

labels = pd.read_csv(labels_filename, header=None)[0].astype(str).values

def draw_ped(img, label, x0, y0, xt, yt, color=(255,127,0), text_color=(255,255,255)):

    (w, h), baseline = cv2.getTextSize(label, cv2.FONT_HERSHEY_SIMPLEX, 0.5, 1)
    cv2.rectangle(img,
                  (x0, y0 + baseline),
                  (max(xt, x0 + w), yt), 
                  color, 
                  2)
    cv2.rectangle(img,
                  (x0, y0 - h),  
                  (x0 + w, y0 + baseline), 
                  color, 
                  -1)  
    cv2.putText(img, 
                label, 
                (x0, y0),                   
                cv2.FONT_HERSHEY_SIMPLEX,     
                0.5,                          
                text_color,                
                1,
                cv2.LINE_AA) 
    return img

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
    
face_cascade = cv2.CascadeClassifier('haarcascades/haarcascade_frontalface_default.xml')
def read_model(filename, path=""):
    with open(os.path.join(path, filename), 'rb') as in_name:
        model = pickle.load(in_name)
        return model
# --------- using SVM scikit + LBPH Scikit -------------
# Load trained model
model = read_model("lbph_svm_model_v2.pkl", path="")

# Initialize the video capture
cap = cv2.VideoCapture(0)

while cap.isOpened():
    ret, frame = cap.read()
    if ret:
        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
        faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=3)
        
        for (x, y, w, h) in faces:
            face_img = gray[y:y+h, x:x+w]
            face_img = cv2.resize(face_img, (100, 100))
            face_img = face_img.reshape(1, 100, 100)
            idx, confidence_scores = model.predict(face_img)
            
            # Get maximum confidence score
            max_confidence = np.max(confidence_scores)*100
            
            if max_confidence > 20:  # Confidence threshold example
                label_text = "%s (%.2f %%)" % (labels[idx], max_confidence)
                frame = draw_ped(frame, label_text, x, y, x + w, y + h, color=(0,255,255), text_color=(50,50,50))
        
        cv2.imshow('Detect Face', frame)
        
        if cv2.waitKey(10) == ord('q'):
            break
    else:
        break

cv2.destroyAllWindows()
cap.release()
