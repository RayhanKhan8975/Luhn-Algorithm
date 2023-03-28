function luhn(number){
	var numarray = number.toString().split('');

	var lastnum = numarray.pop();

	var reverse = numarray.reverse();

	for(var i = 0; i < reverse.length;i++){
	reverse[i] = parseInt(reverse[i]);
	if ( i % 2 === 0) {
	if (reverse[i] * 2 > 9 ) {
		reverse[i] = reverse[i] * 2 - 9;
		//console.log(reverse[i])
	}
	else{

		reverse[i] = reverse[i] * 2
		//console.log(reverse[i])
	}
    
	}
}
var sum = reverse.reduce((a,b) => a + b);
/*if(lastnum === sum % 10){
return true;
}
else{
return false;
}
*/
    var sum = sum % 10;

    return sum == lastnum;

	}