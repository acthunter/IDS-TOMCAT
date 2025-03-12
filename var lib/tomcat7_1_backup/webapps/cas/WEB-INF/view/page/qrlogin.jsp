<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<c:set var="ctx" value="${pageContext.request.contextPath}" />
<!DOCTYPE html>
<html>
<head>
<title>Cas Secure Qr Login</title>
<script src="${ctx}/js/sockjs/sockjs.js"></script>
<script src="${ctx}/js/sockjs/stomp.js"></script>
<script src="${ctx}/js/jquery.min.js"></script>
<script type="text/javascript" src="${ctx}/js/fingerprint.js"></script>
<script type="text/javascript">
	
        var stompClient = null;
        var qtimer = null;
        var isStop = false;
        var sessionId = null;

        var finalurl = null;
      	var fingerprintId = "";
      	
      	$(function() {
		     fingerprintId = new Fingerprint({screen_resolution: true, canvas: true}).get();
		});
      	
        function setConnected(connected) {
            document.getElementById('connect').disabled = connected;
            document.getElementById('disconnect').disabled = !connected;
            document.getElementById('calculationDiv').style.visibility = connected ? 'visible' : 'hidden';
            document.getElementById('calResponse').innerHTML = '';
        }

        $.urlParam = function(name){
		    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
		    if (results==null){
		       return null;
		    }
		    else{
		       return decodeURI(results[1]) || 0;
		    }
		}
        
        function connect() {
            var socket = new SockJS('${ctx}/qrsockjs');
			stompClient = Stomp.over(socket);
            stompClient.connect({}, function(frame) {
            	var urls = (socket._transport.url).split("/");
            	sessionId = urls[urls.length-2];
            	$("#sessId").text(sessionId);
                setConnected(true);
                refreshqr();
                setInterval(refreshqr, 40000);
                
                stompClient.subscribe('/user/queue/web/reply', function(resp){
                //stompClient.subscribe('/user/' + sessionId + 'queue/reply', function(resp){
                	console.log('response: ' + resp);
                	var qresp = JSON.parse(resp.body);
                	
					var vtype = qresp.name;
					switch(vtype){
					case 'grantedlogin':
						console.log(qresp.map.url);
						$("#qr64").attr("src", "");
						$("#orgText").text(qresp.map.url);
						finalurl = qresp.map.url;
	                	window.location.href=finalurl;
						break;
					case 'qrshow':
						var key = qresp.map.key;
	                	$("#qr64").attr("src", "data:image/gif;base64," +  key);
	                	$("#orgText").text(qresp.map.org);	                	
	                	break;
					}
                	
                });
            });
        }

        function disconnect() {
            stompClient.disconnect();
            setConnected(false);
            console.log("Disconnected");
        }

        
        function refreshqr() {
        	if (!isStop){
        		var cvar={ 'ipAddress': "myIpPlease", 'desc': 'any desc', 
                		'fingerprint': fingerprintId}; 
        		var cservice =  $.urlParam('service');
        		if (cservice != null && cservice.length > 2)
        			cvar['service'] = cservice;
        		stompClient.send("/app/showqr", {}, JSON.stringify(cvar));
        	}
        }

        function showResult(message) {
            var response = document.getElementById('calResponse');
            var p = document.createElement('p');
            p.style.wordWrap = 'break-word';
            p.appendChild(document.createTextNode(message));
            response.appendChild(p);
        }
        $(function(){
        	connect();
        });
    </script>
</head>
<body>
	<noscript>
		<h2>Enable Java script and reload this page to run Websocket Demo</h2>
	</noscript>
	<h1>Cas QR Login</h1>
	<div>
		<div style="display: none;">
			<div>
				<button id="connect" onclick="connect();">Connect</button>
				<button id="disconnect" disabled="disabled" onclick="disconnect();">Disconnect</button>
				<br />
				<br />
			</div>
			<div id="calculationDiv">
				<label>Number One:</label><input type="text" id="num1" /><br /> <label>Number
					Two:</label><input type="text" id="num2" /><br />
				<br />
				<button id="sendNum" onclick="refreshqr();">Send to Add</button>
				<p id="calResponse"></p>
			</div>
		</div>
		<p style="display: none;" id="sessId"></p>
		<img style="width: 300px; height: 300px;" id="qr64"
			onclick="refreshqr();" />
		<hr />
		<p style="display: none;" id="orgText"></p>
	</div>
</body>
</html>