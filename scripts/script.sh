#!/usr/bin/bash

# Path to your input file
input_file="./ingredients.txt"

# Path where you want to store the downloaded images
image_path="./"

# Read the file line by line
while IFS='|' read -r ingredient_id ingredient_name image_url; do
    # Generate a unique filename for the image based on the ingredient name
    # filename=$(echo "$ingredient_name" | tr ' ' '_' | tr -d '\r' | tr -d '\n' | tr -d '\t' | tr -d '\0')_$(date +%s).jpg
    # filename=$(echo "$ingredient_name" | tr ' ' '_' | tr -d '\r' | tr -d '\n' | tr -d '\t' | tr -d '\0')_${ingredient_id}.jpg
    filename=$(echo "" | tr ' ' '_' | tr -d '\r' | tr -d '\n' | tr -d '\t' | tr -d '\0')${ingredient_id}.jpg

    image_url=$(echo "$image_url" | tr -d '\r\n')
    wget --output-document="$image_path/$filename" "$image_url"

    # Check if the wget command was successful
    if [ $? -eq 0 ]; then
        echo "Image for '$ingredient_name' downloaded and saved as '$filename'."
    else
        echo "Failed to download image for '$ingredient_name'. Url $image_url"
    fi
    
done < "$input_file"