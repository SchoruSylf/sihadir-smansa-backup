from flask import Flask, request, jsonify
import requests
import os
import csv

app = Flask(__name__)

@app.route('/process-data', methods=['POST'])
def process_data():
    data = request.json  # Assuming data is sent in JSON format

    # Extract CSV file path and other parameters from the request
    csv_file_path = data.get('csv_file_path')
    output_directory = 'organized_data'
    os.makedirs(output_directory, exist_ok=True)

    with open(csv_file_path, mode='r') as file:
        reader = csv.DictReader(file)
        
        for row in reader:
            folder_name = os.path.join(output_directory, row['Nama'])
            os.makedirs(folder_name, exist_ok=True)
            
            for i, url_field in enumerate(['Foto wajah depan', 'Foto wajah menghadap kiri', 'Foto wajah melihat kanan', 'Foto wajah menghadap bawah']):
                url = row[url_field]
                if url.startswith("http"):
                    file_name = f"image_{i+1}.jpg"
                    file_path = os.path.join(folder_name, file_name)
                    
                    response = requests.get(url)
                    with open(file_path, 'wb') as img_file:
                        img_file.write(response.content)

            info_file_path = os.path.join(folder_name, 'info.txt')
            with open(info_file_path, 'w') as info_file:
                info_file.write(f"NISN: {row['NISN']}\nEmail: {row['Email Address']}\n")
    
    return jsonify({"status": "success", "message": "Data processed successfully."}), 200

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
