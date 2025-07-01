FROM node:current-alpine

WORKDIR /var/www/html

COPY package*.json ./

RUN npm install

EXPOSE 3000

CMD ["npm", "start"]