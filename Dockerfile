FROM php:8.1-cli

WORKDIR /app

COPY . /app

RUN chmod +x start.sh

EXPOSE 10000

CMD ["./start.sh"]
