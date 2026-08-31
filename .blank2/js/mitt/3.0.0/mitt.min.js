/**
 * Skipped minification because the original files appears to be already minified.
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
module.exports=function(n){return{all:n=n||new Map,on:function(e,t){var i=n.get(e);i?i.push(t):n.set(e,[t])},off:function(e,t){var i=n.get(e);i&&(t?i.splice(i.indexOf(t)>>>0,1):n.set(e,[]))},emit:function(e,t){var i=n.get(e);i&&i.slice().map(function(n){n(t)}),(i=n.get("*"))&&i.slice().map(function(n){n(e,t)})}}};
//# sourceMappingURL=mitt.js.map
