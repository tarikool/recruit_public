import expect from 'expect.js';
import sinon from 'sinon';
global.travis = process.env.TRAVIS;

var jsdom = require('jsdom').jsdom;
global.document = jsdom('<html><head></head><body></body></html>');
global.window = document.defaultView;
global.navigator = window.navigator = {
  userAgent: 'NodeJS JSDom',
  appVersion: ''
};
