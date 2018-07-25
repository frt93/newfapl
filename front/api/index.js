const express = require('express');
const app = express();

const bodyParser = require("body-parser");
const articles = require('./routes/articles');
const filt = require('./routes/filters');

app.use(bodyParser.urlencoded({extended : false}));
app.use(bodyParser.json());
app.use(articles);
app.use(filt);
app.use(async (req, res, next) => {
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE");
  res.setHeader("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept, Authorization");
  next();
});

module.exports = {
  path: '/api',
  handler: app
}