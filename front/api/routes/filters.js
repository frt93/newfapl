const { Router } = require('express');
const router = Router();
const axios = require('../plugins/axios');

router.post('/filters', function (req, res) {
  let query = '';
  if ( req.body.getclubslist || req.body.getplayerslist) {
    query = '?'
  }

  if ( req.body.getclubslist && req.body.getclubslist != 'all' ) query = query + '&getclubslist=' + req.body.getclubslist;
  if ( req.body.getplayerslist && req.body.getplayerslist != 'all' ) query = query + '&getplayerslist=' + req.body.getplayerslist;

  axios.get(`/filters${query}`)
    .then( function (response) {
      res.json(response.data)
    })
    .catch( function( err ) {
      res.status(500).json({ 'error': 'Something failed!' });
    })
})

module.exports = router