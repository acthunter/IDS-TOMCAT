

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>

<link type="text/css" rel="stylesheet"
	href="<c:url value="/css/cas-pm.css" />" />
<link rel="stylesheet" type="text/css" href="css/cform/demo.css" />
<link rel="stylesheet" type="text/css" href="css/cform/style2.css" />
<link rel="stylesheet" type="text/css"
	href="css/cform/animate-custom.css" />

<c:url var="formActionUrl" value="/login" />

<header>


	<c:if test="${not empty securityQuestionValidationError}">
		<div class="errors" style="width: 250px;">
			<spring:message code="pm.answerSecurityQuestion.error" />
		</div>
	</c:if>

	<p class="note">
		<spring:message code="pm.answerSecurityQuestion.heading-text" />
	</p>


</header>
<div class="container">

	<section>
		<div id="container_demo">
			<div id="wrapper">
				<div id="login" class="animate form">
					<h1>Verifikasi QR</h1>
					<form:form method="post" action="${formActionUrl}"
						class="fm-v clearfix">
						<p style="padding: 15px;">

							<img id="QrImage" src="captcha.jpg?mode=qr" alt="Image verification"
								style="border: 1px solid grey; border-radius: 5px; clear: left;"
								onclick="return reloadImage();" />
						</p>
						
						<c:forEach items="${tokenChallenge.questions}" var="question"
							varStatus="status">
							<p class="sec_question"></p>
							<p class="row fl-controls-left">
								<label class="fl-label" for="username"><c:out
										value="${question.questionText}" /></label> <input type="text"
									autocomplete="false" size="25" value="" accesskey="n"
									tabindex="1" class="required" name="response${status.index}"
									id="username">
							</p>
						</c:forEach>

						
						<p class="signin button">
							<input type="hidden" value="submitAnswer" name="_eventId" /> <input
								type="hidden" name="lt" value="${loginTicket}" /> <input
								type="hidden" name="execution" value="${flowExecutionKey}" />
							<input type="submit" tabindex="2"
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
	</section>
</div>


