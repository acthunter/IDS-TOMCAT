

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>

<link type="text/css" rel="stylesheet"
	href="<c:url value="/css/cas.css" />" />
<link rel="stylesheet" type="text/css" href="css/cform/demo.css" />
<link rel="stylesheet" type="text/css" href="css/cform/style2.css" />
<link rel="stylesheet" type="text/css" href="css/cform/cas17.css" />
<link rel="stylesheet" type="text/css"
	href="css/cform/animate-custom.css" />

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#username").click(function(e) {
			$(".errors").hide();
		});
	});
</script>

<c:url var="continueUrl" value="login">
	<c:param name="_eventId" value="continue" />
	<c:param name="execution" value="${flowExecutionKey}" />
</c:url>
<spring:message code="cas.apps.target.${targetApps}"
	var="targ_apps_desc" />

<div style="height: 560px;">
	<div style="margin-top: 50px;">
		<div id="wrapper" style="width: 450px;">
			<div id="login" class="animate form">
				<h1>
					<spring:message code="cas.notice.passwd.header" />
				</h1>
				<br>
				<ol class="square">
					<li><spring:message code="cas.notice.passwd_success.desc"
							arguments="${targ_apps_desc}" /></li>
					<li><c:choose>
							<c:when test="${pmExtra eq 'wait'}">
								<spring:message code="pm.changedPassword.wait"
									arguments="${continueUrl}" />
							</c:when>
							<c:when test="${pwdTarget eq 'ok'}">
									<c:choose>
										<c:when test="${deliveryMode eq 'online'}">
											<spring:message code="pm.changedPassword.target.online" />
										</c:when>
										<c:otherwise>
											<spring:message code="pm.changedPassword.target.manual" />
										</c:otherwise>
									</c:choose>
							</c:when>
							<c:otherwise>
								<spring:message code="pm.changedPassword.text" arguments="login" />
							</c:otherwise>
						</c:choose></li>
				</ol>

			</div>
		</div>
	</div>
</div>