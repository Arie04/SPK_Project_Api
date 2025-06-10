import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.tree import DecisionTreeClassifier
from sklearn.preprocessing import LabelEncoder
import joblib

# === 1. Load dan persiapkan data ===
df = pd.read_csv("dataset.csv")

# Fitur dan target
X = df.drop(columns=["ModelName", "ProblemDetected"])
y = df["ProblemDetected"]

# Encode target label
label_encoder = LabelEncoder()
y_encoded = label_encoder.fit_transform(y)

# Simpan encoder untuk decoding saat prediksi
joblib.dump(label_encoder, "label_encoder.pkl")

# Split data
X_train, X_test, y_train, y_test = train_test_split(X, y_encoded, test_size=0.2, random_state=42)

# === 2. Latih model Decision Tree ===
clf = DecisionTreeClassifier(random_state=42)
clf.fit(X_train, y_train)

# Simpan model
joblib.dump(clf, "decision_tree_model.pkl")

print("Model berhasil dilatih dan disimpan!")

# === 3. Fungsi prediksi ===
def prediksi_kerusakan(cpu, ram, suhu, voltase, disk, fan):
    # Load model & encoder
    model = joblib.load("decision_tree_model.pkl")
    encoder = joblib.load("label_encoder.pkl")
    
    # Siapkan data
    data_baru = pd.DataFrame([{
        "CPUUsage": cpu,
        "RAMUsage": ram,
        "Temperature": suhu,
        "Voltage": voltase,
        "DiskUsage": disk,
        "FanSpeed": fan
    }])
    
    # Prediksi
    prediksi_encoded = model.predict(data_baru)[0]
    prediksi_label = encoder.inverse_transform([prediksi_encoded])[0]
    return prediksi_label

# === 4. Contoh penggunaan ===
hasil = prediksi_kerusakan(cpu=60.0, ram=80.0, suhu=72.0, voltase=11, disk=15, fan=1900)
print("Hasil Prediksi Kerusakan:", hasil)

"""
$disk = 15;
$cpu = 60;
$ram = 80;
$volt = 11;
$temp = 72;
$fan  = 1900;
"""