const express = require('express');
const jwt = require('jsonwebtoken');
const fs = require('fs');
const path = require('path');
const cookieParser = require('cookie-parser');

const app = express();
app.use(express.urlencoded({ extended: true }));
app.use(cookieParser());

const PRIVATE_KEY = fs.readFileSync('./keys/private.pem', 'utf8');
const PUBLIC_KEY = fs.readFileSync('./keys/public.pem', 'utf8');

const USERS = { 'user': 'pass' }; // Chỉ có user bình thường

app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'views', 'index.html'));
});

app.post('/login', (req, res) => {
  const { username, password } = req.body;
  if (USERS[username] && USERS[username] === password) {
    const token = jwt.sign({
      username,
      role: "user"
    }, PRIVATE_KEY, { algorithm: "RS256" });

    res.cookie('token', token);
    return res.redirect('/admin');
  }
  res.sendFile(path.join(__dirname, 'views', 'fail.html'));
});

app.get('/admin', (req, res) => {
  const token = req.cookies.token;
  if (!token) return res.send('No token provided.');

  try {
    const decoded = jwt.verify(token, PUBLIC_KEY); // 👈 Không chỉ định algorithm
    if (decoded.role === "admin") {
      return res.sendFile(path.join(__dirname, 'views', 'admin.html'));
    } else {
      return res.send('Access denied. Not admin.');
    }
  } catch (e) {
    return res.send('Invalid token.');
  }
});

app.get('/public.pem', (req, res) => {
  res.type('text/plain');
  res.send(PUBLIC_KEY);
});

app.listen(8080, () => {
  console.log('Listening on http://localhost:8080');
});
