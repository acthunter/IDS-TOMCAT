
<%@ page pageEncoding="UTF-8"%>
<%@ page contentType="text/html; charset=UTF-8"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>
<html>
<body>
	<c:if test="${not pageContext.request.secure}">
		<div id="msg" class="errors">
			<h2>Non-secure Connection</h2>
			<p>You are currently accessing CAS over a non-secure connection.
				Single Sign On WILL NOT WORK. In order to have single sign on work,
				you MUST log in over HTTPS.</p>
		</div>
	</c:if>
	<script type="text/javascript" src="js/casmd5.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/fingerprint.js"></script>

	<spring:eval var="autocomplete"
		expression="@casProperties.getProperty('cas.jsp.autocomplete')" />
	<script type="text/javascript">
		$(function() {
			console.log("ready!");
			var fingerprint = new Fingerprint({
				screen_resolution : true,
				canvas : true
			}).get();
			$("#fingerprint").val(fingerprint);
		});
		function hashPass() {
			var uname = $("#username").val();
			var fpass = $("#password");

			var ppass = fpass.val();
			var hash = hashForTransport(uname, ppass);
			console.log(hash);
			fpass.val(hash);
			return true;
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
		
		function sendEvent(command) {
			var form = document.createElement("form");
			var element1 = document.createElement("input");
			var element2 = document.createElement("input");
			var element3 = document.createElement("input");
			var element4 = document.createElement("input");

			form.method = "POST";
			form.action = "login";

			element1.value = command;
			element1.name = "_eventId";
			//element1.name="fname";
			form.appendChild(element1);

			element2.value = "${flowExecutionKey}";
			element2.name = "execution";

			element3.value = new Fingerprint({
				screen_resolution : true,
				canvas : true
			}).get();
			element3.name = "fingerprint";

			element4.value = $.urlParam('service');
			element4.name="service";
			
			form.appendChild(element2);
			form.appendChild(element3);
			form.appendChild(element4);
			console.log();
			document.body.appendChild(form);

			form.submit();
		}
	</script>

	<form:form method="post" id="fm1" commandName="${commandName}"
		htmlEscape="true" width="100%" autocomplete="${autocomplete}">

		<form:errors path="*" id="msg" cssClass="errors"
			style=" background:none; margin-top:-21px; padding-top:80px; width:98%"
			element="div" htmlEscape="false" />
		<table cellpadding="0" cellspacing="0" align="center" width="100%">
			<tr>
				<td height="386" colspan="2" align="center"><br /> <br /> <br />
					<br />
					<table border="0" width="365" height="386"
						style="background-image: url(images/login.jpg)">
						<tr>
							<td align="center" valign="top">
								<div style="padding-top: 163px; padding-left: 40px;">

									<c:choose>
										<c:when test="${not empty sessionScope.openIdLocalId}">

											<input type="hidden" id="username" name="username"
												value="${sessionScope.openIdLocalId}" />
										</c:when>
										<c:otherwise>
											<form:input cssClass="required" cssErrorClass="error"
												id="username" size="25" tabindex="1"
												accesskey="${userNameAccessKey}" path="username"
												autocomplete="off" htmlEscape="true"
												style="height: 26px; width: 164px;" />
										</c:otherwise>
									</c:choose>

									<!--input type="text" style="height:22px; width:160px; border:solid 1px #ffffff;"/-->
								</div>
								<div style="padding-top: 8px; padding-left: 40px;">
									<!--input type="password" style="height:22px; width:160px; border:solid 1px #ffffff;" /-->
									<form:password cssClass="required" cssErrorClass="error"
										id="password" size="25" tabindex="2" path="password"
										accesskey="${passwordAccessKey}" htmlEscape="true"
										autocomplete="off" style="height: 26px; width: 164px;" />
								</div>
								<div
									style="padding-top: 10px; padding-left: 115px; font-size: 11px; color: #00bec0">
									<a href="#" onclick="sendEvent('forgotPassword');"><spring:message
											code="screen.welcome.link.forgotPassword" /></a>
									<a href="#" onclick="sendEvent('qrlogin');"><img
										src="images/QR_icon.png" style="height: 20px; width: 20px;" /></a>
								</div>
								<div style="padding-top: 20px;">
									<input type="image" src="images/btn_login.jpg" border="0"
										alt="Submit" onclick="return hashPass();" />
								</div>
							</td>
						</tr>
						<tr>
							<td align="center" valign="top"></td>
						</tr>
					</table>
				<td>
			</tr>
		</table>


		<section class="row check"
			style="border-bottom-width: 0px; margin-bottom: -20px;">
			<center>
				<input id="warn" name="warn" value="true" tabindex="3"
					accesskey="<spring:message code="screen.welcome.label.warn.accesskey" />"
					type="checkbox" /> <label for="warn"><spring:message
						code="screen.welcome.label.warn" /></label>
			</center>
		</section>

		<section class="row btn-row">
			<input id="fingerprint" type="hidden" name="fingerprint" value="" />
			<input type="hidden" name="lt" value="${loginTicket}" /> <input
				type="hidden" name="execution" value="${flowExecutionKey}" /> <input
				type="hidden" name="_eventId" value="submit" />
		</section>
	</form:form>
</body>
</html>