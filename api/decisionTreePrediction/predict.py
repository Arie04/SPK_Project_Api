import sys
import json
import pandas as pd
import joblib

# Ambil argumen JSON dari CLI
if len(sys.argv) != 2:
    print("Invalid input")
    sys.exit(1)

try:
    input_json = sys.argv[1]
    input_list = json.loads(input_json)

    # Format ke DataFrame (urutan fitur harus sama)
    df = pd.DataFrame([{
        "CPUUsage": input_list[0],
        "RAMUsage": input_list[1],
        "Temperature": input_list[2],
        "Voltage": input_list[3],
        "DiskUsage": input_list[4],
        "FanSpeed": input_list[5]
    }])

    # Load model & encoder
    model = joblib.load("../api/decisionTreePrediction/decision_tree_model.pkl")
    encoder = joblib.load("../api/decisionTreePrediction/label_encoder.pkl")

    # Prediksi
    pred = model.predict(df)[0]
    
    #result = encoder.inverse_transform([pred])[0]

    # Cetak hasil ke stdout
    #print(result)

    print(pred)

except Exception as e:
    print(f"Error: {e}")
    sys.exit(1)
