

<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>

<link type="text/css" rel="stylesheet"
	href="<c:url value="/css/cas-pm.css" />" />
<link rel="stylesheet" type="text/css" href="css/cform/demo.css" />
<link rel="stylesheet" type="text/css" href="css/cform/style2.css" />
<link rel="stylesheet" type="text/css" href="css/cform/cas17.css" />
<link rel="stylesheet" type="text/css"
	href="css/cform/animate-custom.css" />
	
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
    $("#username").click(function(e) {
        $(".error").hide();
    });
});



</script>
<c:url var="formActionUrl" value="/login" />





		<div style='height: 480px; '>
        <div style="margin: 50px; ">
            <div class="box0">
				<div class="box0L" style="margin-top:55px;" >
					<ol class="square">
						
						<c:if test="${retryAllowed == 'NO'}">
							<p class=><li class="error" style="color:red;">Silahkan Coba Kembali</li></p>
						</c:if>
						<p class="sec_question"></p>
						<c:forEach items="${tokenChallenge.questions}" var="question" varStatus="status">
							<c:choose>
								<c:when test="${question.questionText == 'NPP'}">
									<li> Masukan NPP anda untuk tahap verifikasi </li>
								</c:when>
								<c:otherwise>
								<li>Anda akan mendapatkan pesan yang berisi 6 angka kode verifikasi pada nomor handphone yang terdaftar </li>
								<li>Anda memiliki 1 kesempatan tambahan, Jika anda tidak menerima pesan pertama</li>
								<li>Silahkan hubungi 29946000, Jika anda tidak mendapatkan pesan yang berisi kode verifikasi.</li>
								</c:otherwise>
							</c:choose>
						</c:forEach>

					</ol>
				</div >
				<div class="box0R">
					<div id="wrapper">
						<div id="login" class="animate form">
							<c:forEach items="${tokenChallenge.questions}" var="question" varStatus="status">
							<c:choose>
								<c:when test="${question.questionText == 'NPP'}">
									<h1>Verifikasi NPP</h1>
								</c:when>
								<c:otherwise>
									<h1>Verifikasi OTP</h1>
								</c:otherwise>
							</c:choose>
						</c:forEach>
							
							<form:form method="post" action="${formActionUrl}"
								class="fm-v clearfix" modelAttribute="netIdBean"
								autocomplete="off">

								<c:if test="${otpMode == 'email'}">
									<p style="padding: 15px;">

										<img id="QrImage" src="captcha.jpg?mode=qr"
											alt="Image verification"
											style="border: 1px solid grey; border-radius: 5px; clear: left;"
											onclick="return reloadImage();" />
									</p>
								</c:if>
								<c:if test="${otpMode == 'otprsa'}">
									<p style="padding: 15px;">

										<img style="width: 150px; height: 150px;" id="qr64"
									src="data:image/gif;base64,${otpRsaEncryptedQr}" />
									</p>
								</c:if>
								<p class="sec_question"></p>
								<c:forEach items="${tokenChallenge.questions}" var="question"
									varStatus="status">

									<p class="row fl-controls-left" style="margin-left: 7%;">
										<label class="fl-label" for="username"><spring:message
												code="${question.questionText}" /></label> <input type="text"
											autocomplete="false" size="25" value="" accesskey="n"
											tabindex="1" class="required" name="response${status.index}"
											id="username" style="width: 85%;">
											<c:if test="${not empty securityQuestionValidationError}">
												<p class="sec_question"></p>
													<c:forEach items="${tokenChallenge.questions}" var="question" varStatus="status">
														<c:choose>
															<c:when test="${question.questionText == 'NPP'}">
																<p class="error" style="color:red;font-size:9px; margin-left:7%; margin-top:-15px;"><spring:message code="pm.answerSecurityQuestion.error" /></p>
															</c:when>
															<c:otherwise>
																<p class="error" style="color:red;font-size:9px; margin-left:7%; margin-top:-15px;"><spring:message code="pm.answerSecurityQuestion.error.token" /></p>
															</c:otherwise>
														</c:choose>
													</c:forEach>
												<!--<p class="error" style="color:red;font-size:9px; margin-left:7%; margin-top:-15px;"><spring:message code="pm.answerSecurityQuestion.error" /></p>-->
											</c:if>
									</p>

								</c:forEach>
								
								<p class="signin button">
									<input type="hidden" name="lt" value="${loginTicket}" /> <input
										type="hidden" name="execution" value="${flowExecutionKey}" />
									<c:if test="${resendTokenAllowRepeat}">
										<button type="submit" tabindex="2" value="resendToken"
											name="_eventId" class="btn-submit">Resend</button>
									</c:if>
									<button type="submit" tabindex="2" value="submitAnswer"
										name="_eventId" class="btn-submit">
										<spring:message code="pm.form.submit" />
									</button>
									<input type="reset" tabindex="3"
										value="<spring:message code="pm.form.clear" />"
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