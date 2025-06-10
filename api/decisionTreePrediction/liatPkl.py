from sklearn.tree import export_text

# Lihat aturan decision tree dalam bentuk teks
from sklearn import tree
import joblib

# Load file model
model = joblib.load("decision_tree_model.pkl")

feature_names = ["DiskUsage", "CPUUsage", "RAMUsage", "Voltage", "Temperature", "FanSpeed"]
rules_text = export_text(model, feature_names=feature_names)
print(rules_text)
