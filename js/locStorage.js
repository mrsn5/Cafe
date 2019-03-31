var basil = require("basil.js");

options = {
    storages: ['session']
};

basil = new basil(options);

exports.set = function(key, value){
    basil.set(key, value);
};

exports.get = function(key){
    return basil.get(key);
};