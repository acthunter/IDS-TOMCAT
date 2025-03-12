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
<script type="text/javascript" src="js/casmd5.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript">
	function hashField(uname, ftag) {
		var fo = $(ftag);
		if (fo.length)
			fo.val(hashForTransport(uname, fo.val()));
	}
	function hashPass() {
		var uname = $("#username").val();
		hashField(uname, "#oldPassword");
		hashField(uname, "#newPassword");
		hashField(uname, "#confirmNewPassword");
		return true;
	}

	$.validator.addMethod("regx", function(value, element, regexpr) {
		return regexpr.test(value);
	}, "Please enter a valid pasword.");

	$(function() {
		$('[id="cpwdForm"]')
				.validate(
						{
							rules : {
								newPassword : {
									required : true,
									minlength : 8,
									//regx:  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\$\@\$\!\%\*\?\&\.])[a-zA-Z\d\$\@\$\!\%\*\?\&\.]{8,}$/
									//regx : /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!@#$%^&*\(\):])[A-Za-z\d$@$!%*?&.]/
									regx : /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!@#$%^&*\(\)\-\_\=\+\\\/:])[A-Za-z\d$@$!%*?&.]/
								},
								confirmNewPassword : {
									required : true,
									minlength : 8,
									equalTo : "#newPassword",
									//regx:  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\$\@\$\!\%\*\?\&\.])[a-zA-Z\d\$\@\$\!\%\*\?\&\.]{8,}$/
									//regx : /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!@#$%^&*\(\):])[A-Za-z\d$@$!%*?&.]/
									regx : /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!@#$%^&*\(\)\-\_\=\+\\\/:])[A-Za-z\d$@$!%*?&.]/
								},
							},
							messages : {
								newPassword : {
									required : "Please enter new password",
								//minlength: "Your npp must be at least 8 number long",
								//regex: "Too simple"
								},
								confirmNewPassword : {
									required : "Please enter new password",
									//minlength: "Your npp must be at least 8 number long",
									equalTo : "Password not match",
									regex : "Too simple"
								},
							},
							highlight : function(element) {
								$(element).parent().addClass('error')
							},
							unhighlight : function(element) {
								$(element).parent().removeClass('error')
							},
							submitHandler : function(form) {

								hashPass();
								console.log("about to submit");
								form.submit();
							}
						});
	});

	$(document).ready(function() {
		
    $("#oldPassword,#newPassword").click(function(e) {
        $(".error").hide();
    });
    
    $("#oldPassword").val("");
    $("#newPassword").val("");
    $("#confirmNewPassword").val("");
    
});
</script>

<c:url value="/login" var="formActionUrl" />

			<div style='height: 480px; '>
				<div style="margin: 50px; ">
					<div class="box0">
						<div class="box0L" >
							<ol class="square">
								<p class="note">
									<c:choose>
										<c:when test="${pwdChangeForced}">
											<li><spring:message code="pm.changePassword.heading-text.forced" />
											</li>
										</c:when>
										<c:otherwise>
											<li><spring:message code="pm.changePassword.heading-text" />
											</li>
											<li><spring:message code="pm.changePassword.heading-text-simbol" />
											</li>
											<c:if test="${flowRequestContext.currentState.id != 'setPassword'}">
											<li><spring:message
												code="pm.changePassword.heading-text.enter-current-pwd" />
											</li>
											</c:if>
										</c:otherwise>
									</c:choose>
								</p>
							</ol>
						</div >
						<div class="box0R">
							<div id="wrapper">
								<div id="login" class="animate form">
									<form:form method="post" action="${formActionUrl}"
						class="fm-v clearfix" modelAttribute="changePasswordBean"
						id="cpwdForm">

										<c:choose>
											<c:when test="${pwdChangeForced}">
												<h1>
													<spring:message code="pm.changePassword.header.forced" />
												</h1>
											</c:when>
											<c:otherwise>
												<h1>
													<spring:message code="pm.changePassword.header" />
												</h1>
											</c:otherwise>
										</c:choose>

										<p>
											<label for="username" class="uname" data-icon="u">
												<spring:message
									code="pm.form.netid" />
											</label>
											<c:choose>
												<c:when test="${username != null}">
													<form:input path="username" type="text" disabled="true"
										autocomplete="false" size="25" value="${username}"
										accesskey="n" tabindex="1" cssClass="required" id="username"
										placeholder="myusername or mymail@mail.com" style="width:92%;" />
													<form:errors path="username" cssClass="error" />
												</c:when>
												<c:otherwise>
													<spring:message code="pm.form.netid.accesskey"
										var="netIdAccessKey" />
													<form:input path="username" type="text" autocomplete="false"
										size="25" accesskey="${netIdAccessKey}" tabindex="1"
										cssClass="required" name="username" id="username"
										placeholder="myusername or mymail@mail.com" style="padding: 0px;"/>
													<form:errors path="username" cssClass="error" />
												</c:otherwise>
											</c:choose>
										</p>
										<c:if
							test="${flowRequestContext.currentState.id != 'setPassword'}">
											<p>
												<label for="oldPassword" class="youpasswd" >
													<spring:message code="pm.changePassword.form.password.old" />
												</label>
												<spring:message
									code="pm.changePassword.form.password.old.accesskey"
									var="oldPasswordAccessKey" />
												<form:input path="oldPassword" type="password"
									autocomplete="off" size="25"
									accesskey="${oldPasswordAccessKey}" tabindex="2"
									cssClass="required" id="oldPassword"
									style="width:92%;" />
												<form:errors path="oldPassword" cssClass="error" />
											</p>
										</c:if>

										<p>
											<label class="youpasswd" for="newPassword">
												<spring:message
									code="pm.changePassword.form.password.new" />
											</label>
											<spring:message
								code="pm.changePassword.form.password.new.accesskey"
								var="newPasswordAccessKey" />
											<form:input path="newPassword" type="password" autocomplete="off"
								size="25" accesskey="${newPasswordAccessKey}" tabindex="3"
								cssClass="required" id="newPassword" style="width:92%;" />
											<form:errors path="newPassword" cssClass="error" />
										</p>

										<p>
											<label class="youpasswd" for="confirmNewPassword">
												<spring:message
									code="pm.changePassword.form.password.confirm" />
											</label>
											<spring:message
								code="pm.changePassword.form.password.confirm.accesskey"
								var="confimAccessKey" />
											<form:input path="confirmNewPassword" type="password"
								autocomplete="off" size="25" accesskey="${confirmAccessKey}"
								tabindex="4" cssClass="required" id="confirmNewPassword"
								style="width:92%;" />
											<form:errors path="confirmNewPassword" cssClass="error" />
										</p>
										<c:if test="${empty username }">
											<div>
												<label class="fl-label" for="recaptcha">
													<spring:message
										code="pm.recaptcha.prompt" />
												</label>
												<img src="/captcha.jpg" />
											</div>
										</c:if>
										<p class="signin button">
											<input type="hidden" value="${loginTicket}" name="lt">
												<input
								type="hidden" value="submitChangePassword" name="_eventId">
													<input type="hidden" value="${flowExecutionKey}" name="execution">
														<input type="submit" tabindex="5"
								value="<spring:message code="pm.form.submit" />"
								accesskey="<spring:message code="pm.form.submit.accesskey" />"
								name="submit" class="btn-submit"> <input type="reset"
								tabindex="6" value="<spring:message code="pm.form.clear" />"
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