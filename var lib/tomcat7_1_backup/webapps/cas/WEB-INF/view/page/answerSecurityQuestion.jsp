

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>

<link type="text/css" rel="stylesheet"
	href="<c:url value="/css/cas.css" />" />
<link rel="stylesheet" type="text/css" href="css/cform/demo.css" />
<link rel="stylesheet" type="text/css" href="css/cform/style2.css" />
<link rel="stylesheet" type="text/css" href="css/cform/cas17.css" />
<link rel="stylesheet" type="text/css" href="css/cform/animate-custom.css" />

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
    $("#username").click(function(e) {
        $(".errors").hide();
    });
});



</script>

<c:url var="formActionUrl" value="/login" />
<spring:eval var="autocomplete" expression="@casProperties.getProperty('cas.jsp.autocomplete')" />
		<div style='height: 480px; '>
        <div style="margin: 50px; ">
            <div class="box0">
				<div class="box0L" style="margin-top: 50px;" >
					<ol class="square">
					<p class="note">
						<li><spring:message code="pm.answerSecurityQuestion.heading-text" /></li>
					</p>
					
					<li>Masukkan nomor Handphone atau Email sesuai permintaan sistem, berdasarkan yang terdaftar di Portal HCMS </li>
					<li>Bila diperlukan penyesuaian terhadap nomor Handphone atau Email anda ,Harap menghubungi 29946000 (Service Manajemen Operasional Teknologi Informasi)</li>
					</ol>
				</div >
				<div class="box0R">
				<div id="wrapper">
					<div id="login" class="animate form">
						<h1>Verifikasi Identitas</h1>
						<br>
						<form:form method="post" action="${formActionUrl}"
							class="fm-v clearfix" autocomplete="${autocomplete}">

							<c:forEach items="${securityChallenge.questions}" var="question"
								varStatus="status">
								<p class="sec_question"></p>
								<p class="row fl-controls-left" style="margin-left:7%;">
									<label class="fl-label" for="username"><spring:message
											code="${question.questionText}" /></label> <input type="text"
										autocomplete="false" size="25" value="" accesskey="n"
										tabindex="1" class="required" style="width:85%;" name="response${status.index}"
										id="username">
								</p>
							</c:forEach>
							<c:if test="${not empty securityQuestionValidationError}">
							<div id="hide" >
								<p class="errors" style="color: red; max-width: 400px; margin-left:23px;">
									<spring:message code="pm.answerSecurityQuestion.error" />
								</p>
							</div>
							</c:if>
							
							<p class="signin button">
								<input type="hidden" value="submitAnswer" name="_eventId" /> <input
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
				</div >
			</div>
			</div>
        </div>
