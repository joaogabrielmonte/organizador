FROM php:8.1-cli

WORKDIR /app

COPY . /app

EXPOSE 10000

CMD ["./start.sh"]
