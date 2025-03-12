

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

<c:url var="formActionUrl" value="/login" />
<spring:eval var="autocomplete"
	expression="@casProperties.getProperty('cas.jsp.autocomplete')" />
<div style="height: 560px;">
	<div style="margin-top: 50px;">
		<div id="wrapper" style="width: 450px;">
			<div id="login" class="animate form">
				<h1  style='<spring:message code="cas.notice.${noticeId}.style"/>'>
					<spring:message code="cas.notice.${noticeId}.header" />
				</h1>
				<br>
				<ol class="square">
					<li><spring:message code="cas.notice.${noticeId}.desc" /></li>
				</ol>
				<form:form method="post" action="${formActionUrl}"
					class="fm-v clearfix" autocomplete="${autocomplete}">

					<p class="signin button" style="padding-top: 70px;">
						<input type="hidden" name="lt" value="${loginTicket}" /> <input
							type="hidden" name="execution" value="${flowExecutionKey}" />
						<c:choose>
							<c:when test="${noticeBtnId == 'btnOk'}">
								<input type="submit" tabindex="2" value="Ok" name="_eventId"
									class="btn-submit">
							</c:when>
							<c:when test="${noticeBtnId == 'btnOkCancel'}">
								<input type="submit" tabindex="2" value="Ok" name="_eventId"
									class="btn-submit">
								<input type="submit" tabindex="2" value="Batal" name="_eventId"
									class="btn-submit">
							</c:when>
						</c:choose>

					</p>
				</form:form>
			</div>
		</div>
	</div>
</div>