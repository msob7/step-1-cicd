# Use the official WordPress image as base
FROM wordpress:latest

# Install any packages or PHP extensions
RUN apt-get update && apt-get install -y \
    vim \
    less \
    unzip \
 && rm -rf /var/lib/apt/lists/*

# Copy custom themes or plugins if you have them
# COPY ./my-theme /var/www/html/wp-content/themes/my-theme
# COPY ./my-plugin /var/www/html/wp-content/plugins/my-plugin

# Set working directory
WORKDIR /var/www/html
