

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


<div style='height: 560px;'>
	<div style="margin-top: 50px;">


		<div style="float:center;">
			<div id="wrapper"style="width: 350px;">
				<div id="login" class="animate form" >
					<h1>Pilih Token</h1>
					<form:form method="post" action="${formActionUrl}"
						class="fm-v clearfix">
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

						<!-- p>
								<label class="uname" for="otpMode"><spring:message
										code="pm.otp.label" /></label>
							</p-->
						<div style="padding-left:2%;padding-right:2%;">
						<form:errors id="otpMode" cssClass="error" />
						<p style="text-align: center;">Silahkan Pilih mode OTP Anda</p>
						<p class="row fl-controls-left"style="padding-left: 30px;">
							<label class="fl-label"><c:out
									value="${question.questionText}" /></label>
							<c:forEach var="item" items="${tokenModeMap}">
								<input type="radio" name="otpMode" value="${item}"
									${item == currentOTPMode?'checked':''} style="width: 30px;" />
								<spring:message code="pm.otp.model.${item}" />
								<br>
							</c:forEach>
						</p>
						</div>
						<p class="signin button" style="padding-top: 30px;">
							<input type="hidden" value="submit" name="_eventId" /> <input
								type="hidden" name="lt" value="${loginTicket}" /> <input
								type="hidden" name="execution" value="${flowExecutionKey}" /> <input
								type="submit" tabindex="2"
								value="<spring:message code="pm.form.submit" />"
								accesskey="<spring:message code="pm.form.submit.accesskey" />"
								name="submit" class="btn-submit"> <input type="reset"
								tabindex="3" value="<spring:message code="pm.form.clear" />"
								accesskey="<spring:message code="pm.form.clear.accesskey" />"
								name="reset" class="btn-reset">
						</p>
					</form:form>
				</div>
			</div>
		</div>
	</div>
</div>