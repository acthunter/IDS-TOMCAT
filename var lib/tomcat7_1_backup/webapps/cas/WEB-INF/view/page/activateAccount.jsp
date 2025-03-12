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
	cssClass="fm-v clearfix" modelAttribute="chgpwdBean">

	<h1>
		<spring:message code="pm.activateAccount.header" />
	</h1>
	<c:if test="${not empty forgotPasswordValidationError}">
		<div class="errors" style="width: 250px;">
			<spring:message code="pm.forgotPassword.generic-error" />
		</div>
	</c:if>

	<p>
		<label class="uname" for="username"><spring:message
				code="pm.form.netid" /></label>
		<spring:message code="pm.form.netid.accesskey" var="netIdAccessKey" />
		<form:input path="username" type="text" autocomplete="false" size="6"
			accesskey="${netIdAccessKey}" tabindex="1" cssClass="required"
			id="username" maxlength="6" />
		<form:errors path="username" cssClass="error" />
	</p>

	
	<p>
		<label class="uname" for="password"><spring:message
				code="pm.form.email" /></label>
		<spring:message code="pm.form.email.accesskey" var="emailAccessKey" />
		<form:input path="oldPassword" type="password" autocomplete="false" size="30"
			accesskey="${emailAccessKey}" tabindex="1" cssClass="required"
			id="password"  />
		<form:errors path="oldPassword" cssClass="error" />
	</p>
	
	<spring:eval var="useCaptcha" expression="@casProperties.getProperty('pm.activateAccount.useCaptcha')" />
	
	<c:if test="${useCaptcha}">
		<p style="padding: 15px;">
			<img id="captchaImage" src="captcha.jpg" alt="Image verification"
				style="border: 1px solid blue; border-radius: 5px; float: right; clear: left; margin: -19px 222px;"
				onclick="return reloadImage();" />
		</p>
		<p>
			<label class="fl-label" for="recaptcha_response"><spring:message
					code="pm.recaptcha.prompt" /></label> <input type="text"
				name="recaptcha_response" size="10" autocomplete="off"
				id="recaptcha_response" />
		</p>
	</c:if>	
	
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

