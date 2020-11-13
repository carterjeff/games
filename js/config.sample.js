function debug(arr){
  var string = '';
  for (var pair of arr.entries()){
    string += '&' + pair[0] + '=' + pair[1];    
  }
  console.log(string);
}
