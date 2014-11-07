function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		do {
				curleft += obj.offsetLeft;
				curtop += obj.offsetTop;
			} while (obj = obj.offsetParent);
	}
	return [curleft,curtop];
}

function showexplacition(fh) {
	removeFocused(document);
	addClass(document.getElementById("fh" + fh), "focused");
	var ediv = document.getElementById("explicate");
	document.getElementById("explframe").src = "explicate.php?fh="+fh;
	ediv.style.display='block';
}

function hasClass (ele, cls) {
	return ele.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
}
function addClass (ele, cls) {
	if (!this.hasClass(ele,cls)) ele.className += " " + cls;
}
function removeClass (ele,cls) {
		if (hasClass(ele, cls)) {
			var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
			ele.className = ele.className.replace(reg, ' ');
		}
}

function removeFocused(doc) {
	var elements = doc.getElementsByClassName("focused");
	for (var i=0; (element = elements[i]) != null; i++) {
		removeClass(element, "focused");
	}
}
