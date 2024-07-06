import base64

def encode_base64(data):
    # Convertir la chaîne en bytes (UTF-8)
    bytes_data = data.encode('utf-8')
    
    # Encodage en base64
    encoded_data = base64.b64encode(bytes_data)
    
    # Convertir les bytes encodés en une chaîne de caractères (UTF-8)
    encoded_string = encoded_data.decode('utf-8')
    
    return encoded_string

# Exemple d'utilisation
input_string = "Hello, World!" 
encoded_result = encode_base64(input_string)
print("Chaîne originale:", input_string)
print("Chaîne encodée en base64:", encoded_result)
