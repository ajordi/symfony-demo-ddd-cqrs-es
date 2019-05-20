FROM nginx:1.15.8

# Install dependency for healthcheck
RUN    apt-get update \
    && apt-get install -y netcat \
    && apt-get clean

# Copy nginx configuration
COPY ./docker/nginx/config/ /etc/nginx/

# Copy self-signed SSL certificates (for development)
COPY ./docker/nginx/certs/nginx.crt /etc/ssl/certs/nginx-selfsigned.crt
COPY ./docker/nginx/certs/nginx.key /etc/ssl/private/nginx-selfsigned.key

# Copy public folder containing static content
COPY ./app/public /opt/app/public

# Set working directory
WORKDIR /opt/app/
