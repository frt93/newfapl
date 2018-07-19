const { Router } = require('express');
const router = Router();
const axios = require('../plugins/axios');

const multer = require('multer');
const form = multer();


/* GET articles listing. */
router.post('/articles', function (req, res) {
  let query = '';
  if ( req.body.page || req.body.club || req.body.pl ) {
    query = '?'
  }

  if ( req.body.co ) query = query + '&co=' + req.body.co
  if ( req.body.club ) query = query + '&club=' + req.body.club
  if ( req.body.pl ) query = query + '&pl=' + req.body.pl
  if ( req.body.page ) query = query + '&page=' + req.body.page

  axios.get(`/articles${query}`)
    .then( function (response) {
      response.data.data.forEach((article, i) => {
        let keys = ['created_at', 'updated_at', 'user_id', 'pinned'];

        keys.forEach( (key) => {
          delete article[key]
        });

      })
      res.json(response.data)
    })
    .catch( function( err ) {
      res.status(500).json({ 'error': 'Something failed!' });
    })
})

router.get('/articles/pinned', function (req, res) {
  axios.get('/articles/pinned')
    .then( function (response) {
      let article = response.data;
      let keys = ['created_at', 'updated_at', 'user_id', 'pinned', 'body', 'published'];
      keys.forEach( (key) => {
        delete article[key]
      });

      res.json(article)
    })
    .catch( ( err ) => 
      res.json(err) 
    )
})

/* GET article's create page data */
router.get('/articles/create', function (req, res) {
  axios.get('/articles/create')
    .then( (response) =>
      res.json(response.data)
    )
    .catch( ( err ) => 
      res.json(err) 
    )
})

/* Post new article's data */

router.post('/articles/store', form.fields([]), (req, res) => {
  let article = req.body;

  axios.post('/articles/store', article)
    .then( (response) => {
      res.json( response.data.id )
    } )
    .catch( ( err ) => {
      res.json(err)
    } )
})

/* GET article by ID. */
router.get('/articles/:id', function (req, res) {
  const id = parseInt(req.params.id)

  if ( id > 0 ) {
    axios.get(`/articles/${id}`)
    .then( function (response) {
      let article = response.data;
      let keys = ['created_at', 'updated_at', 'user_id', 'pinned', 'published'];
      keys.forEach( (key) => {
        delete article[key]
      });
      res.json(article)
    })
    .catch( ( err ) => 
      res.json(err) 
    )
  } else {
    res.sendStatus(404)
  }
})

/* GET article's edit page data */
router.get('/articles/:id/edit', function (req, res) {
  const id = parseInt(req.params.id)
  
  if ( id > 0 ) {
    axios.get(`/articles/${id}/edit`)
    .then( (response) =>
      res.json(response.data)
    )
    .catch( ( err ) => 
      res.json(err) 
    )
  } else {
    res.sendStatus(404)
  }
})

/* Update article */
router.post('/articles/update/:id', form.fields([]), (req, res) => {
  const id = parseInt(req.params.id)
  let article = req.body;

  axios.post(`/articles/update/${id}`, article)
    .then( (response) => {
      res.json( response.data )
    } )
    .catch( ( err ) => {
      res.json(err)
    } )
})

/* Publish article */
router.get('/articles/:id/publish' , function (req, res) {
  const id = parseInt(req.params.id)
  
  if ( id > 0 ) {
    axios.get(`/articles/${id}/publish`)
    .then( (response) =>
      res.json(response.data)
    )
    .catch( ( err ) => 
      res.json(err) 
    )
  } else {
    res.sendStatus(404)
  }
})

/* Unpublish article */
router.get('/articles/:id/unpublish' , function (req, res) {
  const id = parseInt(req.params.id)
  
  if ( id > 0 ) {
    axios.get(`/articles/${id}/unpublish`)
    .then( (response) =>
      res.json(response.data)
    )
    .catch( ( err ) => 
      res.json(err) 
    )
  } else {
    res.sendStatus(404)
  }
})

module.exports = router