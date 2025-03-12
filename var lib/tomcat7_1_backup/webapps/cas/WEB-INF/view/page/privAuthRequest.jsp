

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
<c:url var="formActionUrl" value="/login" />
<div style="height: 560px;">
	<div style="margin-top: 50px;">
		<!--<div class="box0C">-->
		<div id="wrapper" style="width: 500px; float: center;">
			<div id="login" class="animate form">
				<h1>
					<spring:message code="pm.uid.form.header" />
				</h1>
				<p>
					<spring:message code="pm.otp.model.${otpMode}" var="otpDesc"/> 
					<spring:message code="pm.uid.form.token.tfa.note"
						arguments="${otpDesc}" />
				</p>
				<p>
				<ol class="square">
					<c:if test="${not empty securityQuestionValidationError}">
						<div class="errors" style="width: 250px;">
							<li style="color: red;"><spring:message
									code="pm.answerSecurityQuestion.error" /></li>
						</div>
					</c:if>
				</ol>
				</p>
				<form:form method="post" action="${formActionUrl}"
					class="fm-v clearfix" modelAttribute="targetPwdBean">

					<div>

						<c:if test="${otpMode == 'otprsa'}">
							<div style="float: left;">
								<img style="width: 150px; height: 150px;" id="qr64"
									src="data:image/gif;base64,${otpRsaEncryptedQr}" />
							</div>
						</c:if>

						<div style="float: right;">
							<p>
							<label class="youpasswd" for="newPassword"><spring:message
									code="pm.uid.form.token.tfa.label" /></label>

							<form:input path="newPassword" type="password" autocomplete="off"
								size="25" accesskey="${newPasswordAccessKey}"
								cssClass="required" id="newPassword" style="width:92%;" />
								<form:errors path="newPassword" cssClass="error" />
							</p>
							<c:if test="${retryAllowed == 'NO'}">
							<p style="color: red; font-size: 10px">Token yang anda
								masukkan salah</p>
							</c:if>

					
					
						<p class="signin button">
							<input type="hidden" value="submitAnswer" name="_eventId" /> <input
								type="hidden" name="lt" value="${loginTicket}" /> <input
								type="hidden" name="execution" value="${flowExecutionKey}" /> <input
								type="submit" value="<spring:message code="pm.form.submit" />"
								accesskey="<spring:message code="pm.form.submit.accesskey" />"
								name="submit" class="btn-submit"> <input type="reset"
								value="<spring:message code="pm.form.clear" />"
								accesskey="<spring:message code="pm.form.clear.accesskey" />"
								name="reset" class="btn-reset">
						</p>
						</p>

						<div class="smallnote"
							style="text-align: center; font-size: 12px;">Silahkan
							hubungi 29946000, Jika anda tidak mendapatkan pesan yang berisi
							kode verifikasi.</div>
					</div>
				</form:form>
			</div>
		</div>
		<!--</div>-->
	</div>
</div>
