

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

<style type="text/css">
.row:after {
	content: "";
	display: table;
	clear: both;
}
.img{
	display: block;
    margin: auto;
    width: 40%;
	
 }

</style>
<div style='height: 480px; '>
				<div style="margin: 50px; ">
					<div class="box0">
						<div class="box0L" style="margin-top: 80px;" >
							<div>
								
								<ol class="square" > <!--style="list-style-type: circle;"-->
								<c:if test="${not empty securityQuestionValidationError}">
									<div class="errors" style="width: 250px;">
										<spring:message code="pm.answerSecurityQuestion.error" />
									</div>
								</c:if>
									<li>Scan Qr berikut melalui menu "Seed Qr" Apps Mobile
										<br><p style="margin-top:20px;">
											<img class="img" src="data:image/png;base64, ${seed64}" alt="seedQr" />
										</p><br>
									</li>
									<li>Input Captcha
										<p ><img id="QrImage" class="img" src="captcha.jpg?mode=scaptcha"
																alt="Image verification"
																style="border: 1px solid grey; border-radius: 5px; clear: left; vertical-align: middle;" /></p>
									</li>

								</ol>
							</div>
						</div>
						
						<div class="box0R">
							
								<div id="wrapper">
									<div id="login" class="animate form">
										<h1>
											<spring:message code="pm.uid.form.header" />
										</h1>
										<%--<p>${seed}</p>  --%>

										<form:form method="post" action="${formActionUrl}"
											class="fm-v clearfix" modelAttribute="targetPwdBean">
											<p class="note" style="text-align:center;">
												<spring:message code="pm.uid.form.token.tfa.note" arguments=" " />
											</p>
											<br>
											<p >
												
												<label class="youpasswd" for="newPassword"
													"><spring:message
														code="pm.uid.form.token.tfa.label" /></label>



												<form:input path="newPassword" type="password"
													autocomplete="off" size="6"
													accesskey="${newPasswordAccessKey}" cssClass="required"
													id="newPassword" style="width:92%;" />
											</p>
											<form:errors path="newPassword" cssClass="error" />



											<p class="signin button" style="padding-top: 40px;">
												<input type="hidden" value="submitAnswer" name="_eventId" /> <input
													type="hidden" name="lt" value="${loginTicket}" /> <input
													type="hidden" name="execution" value="${flowExecutionKey}" />
												<input type="submit"
													value="<spring:message code="pm.form.submit" />"
													accesskey="<spring:message code="pm.form.submit.accesskey" />"
													name="submit" class="btn-submit"> <input type="reset"
													value="<spring:message code="pm.form.clear" />"
													accesskey="<spring:message code="pm.form.clear.accesskey" />"
													name="reset" class="btn-reset">
											</p>
										</form:form>
									</div>
								</div>
							
						</div>
					</div>
				</div>
			</div>


