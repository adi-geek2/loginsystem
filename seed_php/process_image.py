# Seed quality assessment using MobileNetV3
# Seed quality assessment using MobileNetV3 
import sys
import json
import torch
import torch.nn as nn
from torchvision import transforms, models
from PIL import Image
import warnings
from ultralytics import YOLO

# Suppress warnings related to torch.load
warnings.filterwarnings("ignore", category=FutureWarning)

# Function to load the pre-trained mobilnet model
def load_model_mobilnet():
    model = models.mobilenet_v3_large()
    num_classes = 2
    model.classifier[3] = nn.Linear(model.classifier[3].in_features, num_classes)
    model.load_state_dict(torch.load("mobilenet_weights_20241129_132949.pth", map_location=torch.device("cpu"), weights_only=True))
    model.eval()
    return model

# Function to load the pre-trained yolo v11 model
def load_model_yolo():
    model = YOLO("yolo11_v1.pt")
    return model

# Preprocessing pipeline for images
def preprocess_image(image_path):
    transform = transforms.Compose([
        transforms.Resize((224, 224)),  # Resize to match model input size
        transforms.ToTensor(),         # Convert image to tensor
        transforms.Normalize(mean=[0.485, 0.456, 0.406], std=[0.229, 0.224, 0.225])  # Normalize
    ])
    image = Image.open(image_path).convert('RGB')  # Open and convert to RGB
    return transform(image).unsqueeze(0)  # Add batch dimension

# Main function
if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(json.dumps({"error": "No image path provided"}))
        sys.exit(1)

    image_path = sys.argv[1]  # Get image path from PHP script
    try:
        # Preprocess the image
        input_tensor = preprocess_image(image_path)

        # Load MobilNet model and predict
        mobilnet_model = load_model_mobilnet()
        with torch.no_grad():
            output = mobilnet_model(input_tensor)
            predicted_class = torch.argmax(output, dim=1).item()
            quality_score = torch.softmax(output, dim=1)[0][predicted_class].item()

        # Map prediction to class labels
        class_labels = {0: "Bad Seed", 1: "Good Seed"}

        # Add MobilNet result
        mobilnet_result = {
            "model": "MobilNetV3",
            "quality": class_labels[predicted_class],
            "score": round(quality_score, 4),  # Include score rounded to 4 decimals
        }

        # Load YOLO model and predict
        yolo_model = load_model_yolo()
        with torch.no_grad():
            results = yolo_model(image_path, verbose=False)
            predicted_class = results[0].probs.top1  # Predicted class from YOLO
            quality_score = results[0].probs.top1conf.item()  # Confidence score

        # Add YOLO result
        yolo_result = {
            "model": "YOLOv11",
            "quality": class_labels[predicted_class],
            "score": round(quality_score, 4),  # Include score rounded to 4 decimals
        }

    #     # Combine results
    #     combined_result = {
    #         "mobilnet": mobilnet_result,
    #         "yolo": yolo_result,
    #     }

    #     print(json.dumps(combined_result))
    # except Exception as e:
    #     # Handle any errors
    #     print(json.dumps({"error": str(e)}))

        result = {
            "quality": yolo_result["quality"],
            "score": yolo_result["score"]
        }
        print(json.dumps(result))
    except Exception as e:
        # Handle any errors
        print(json.dumps({"error": str(e)}))
