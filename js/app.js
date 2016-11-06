
function maxLength(elm,maximum){
   if (elm.value.length > maximum){
      alert("Wprowadź maksymalnie " + maximum + " znaków");
      elm.value = elm.value.substr(0,maximum);
   }   
}
