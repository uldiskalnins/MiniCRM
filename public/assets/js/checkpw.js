function getPassword($e) {

  var text = $e.value;
  var goodTextMarker = 'text-info'; //laba paroles parametra teksta noformēšanas css klase
  var goodTextInputMarker = 'border-info'; //laba teksta lauka noformēšanas css klase
  checkIfEightChar(text) ? pLength.classList.add(goodTextMarker) : pLength.classList.remove(goodTextMarker);
  checkIfOneLowercase(text) ? pLowercase.classList.add(goodTextMarker) : pLowercase.classList.remove(goodTextMarker);
  checkIfOneUppercase(text) ? pUppercase.classList.add(goodTextMarker) : pUppercase.classList.remove(goodTextMarker);
  checkIfOneDigit(text) ? pNumber.classList.add(goodTextMarker) : pNumber.classList.remove(goodTextMarker);
  checkIfOneSpecialChar(text) ? pSpecial.classList.add(goodTextMarker) : pSpecial.classList.remove(goodTextMarker);

  if ((pLength.classList.contains(goodTextMarker)) && (pLowercase.classList.contains(goodTextMarker))
    && (pUppercase.classList.contains(goodTextMarker)) && (pNumber.classList.contains(goodTextMarker))
    && (pSpecial.classList.contains(goodTextMarker))){$e.classList.add(goodTextInputMarker);}
  else{$e.classList.remove(goodTextInputMarker);}
}
function checkIfEightChar(text){return text.length >= 8;}
function checkIfOneLowercase(text) {return /[a-z]/.test(text);}
function checkIfOneUppercase(text) {return /[A-Z]/.test(text);}
function checkIfOneDigit(text) {return /[0-9]/.test(text);}
function checkIfOneSpecialChar(text) {return /[)(~@`!#$%\^&*+=\-\[\]\\';,./{}|\\":<>\?]/g.test(text);}
