<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>

<script type="text/javascript">
	function reloadImage() {
		img = document.getElementById("captchaImage");
		img.src = "captcha.jpg?" + new Date().getTime();
	}
</script>

<form:form id="fm1" method="post" action="${formActionUrl}"
	cssClass="fm-v clearfix" modelAttribute="netIdBean">

	<h1>
		<spring:message code="pm.forgotPassword.header" />
	</h1>
	<c:if test="${not empty forgotPasswordValidationError}">
		<div class="errors" style="width: 250px;">
			<spring:message code="pm.forgotPassword.generic-error" />
		</div>
	</c:if>

	<p>
		<label class="uname" for="netId"><spring:message
				code="pm.form.netid" /></label>
		<spring:message code="pm.form.netid.accesskey" var="netIdAccessKey" />
		<form:input path="netId" type="text" autocomplete="false" size="6"
			accesskey="${netIdAccessKey}" tabindex="1" cssClass="required"
			id="netId" maxlength="6" />
		<form:errors path="netId" cssClass="error" />
	</p>

	
	<p class="signin button">
		<input type="hidden" name="execution" value="${flowExecutionKey}" />
		<input type="hidden" name="_eventId" value="submitId"> <input
			type="hidden" name="lt" value="${loginTicket}" /> <input
			type="submit" tabindex="2"
			value="<spring:message code="pm.form.submit" />"
			accesskey="<spring:message code="pm.form.submit.accesskey" />"
			name="submit" class="btn-submit">
	</p>

</form:form>

