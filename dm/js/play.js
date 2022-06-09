//此文件建议加密处理
function randomRange(min, max){
    var returnStr = "",
        range = (max ? Math.round(Math.random() * (max-min)) + min : min),
        arr = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
 
    for(var i=0; i<range; i++){
        var index = Math.round(Math.random() * (arr.length-1));
        returnStr += arr[index];
    }
    return returnStr;
}

//定义密钥
var _token_key = CryptoJS.enc.Utf8.parse("A42EAC0C2B408472");//此密钥要跟config.php里的video_key要一致，否则会导致无法解密
//定义IV偏移
var _token_iv = CryptoJS.enc.Utf8.parse(le_token);

//定义IV偏移
var key_token = CryptoJS.enc.Utf8.parse(randomRange(16));

//加密
function v_encrypt(data,token_key,token_iv) {
    return CryptoJS.AES.encrypt(data, token_key, {iv: token_iv, mode: CryptoJS.mode.CBC}).toString();
}

//解密
function v_decrypt(data,token_key,token_iv) {
    return CryptoJS.AES.decrypt(data, token_key, {iv: token_iv}).toString(CryptoJS.enc.Utf8);
}

function getVideoInfo(url){
    return v_encrypt(v_decrypt(url,_token_key,_token_iv),_token_key,key_token);
}