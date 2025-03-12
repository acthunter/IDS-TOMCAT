

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

		<div style='height: 560px; '>
        <div style="margin-top: 50px; ">
            <div class="box0">
				<div class="box0L" >
					<ol class="square">
							<c:if test="${not empty securityQuestionValidationError}">
								<div class="errors" style="width: 250px;">
									<li style="color: red"> <spring:message code="pm.answerSecurityQuestion.error" /></li>
								</div>
							</c:if>
					</ol>
				</div >
			<div class="float:center;">
			<div id="wrapper">
				<div id="login" class="animate form">
					<h1>
						Ubah Password
					</h1>

		
					<form:form method="post" action="${formActionUrl}"
						class="fm-v clearfix"  modelAttribute="targetPwdBean">
						<p class="note" style="text-align:center; padding-bottom: 10px;">
								<spring:message code="pm.changePassword.form.setPassword" />
						</p>
						<p>
						<label for="username" class="uname" data-icon="u"> <spring:message
									code="pm.form.netid" /></label>
						<form:input path="username" type="text" disabled="true"
										autocomplete="false" size="25" 
										accesskey="n" cssClass="required" id="username"
										placeholder="myusername or mymail@mail.com" style="width:92%;"/>
						</p>
						<p>
						<label for="targetSystem" class="uname" data-icon="u"> Target</label>
						<form:select path="targetSystem" cssClass="required" id="targetSystem"
										style="width:92%;">
									<c:forEach items="${appsList}" var="capps">
										<option value="${capps.target}">
											${capps.desc}
										</option>
									</c:forEach>
						</form:select>
						</p>
						<p>
							<label class="youpasswd" for="newPassword"><spring:message
									code="pm.changePassword.form.password.new" /></label>
							<spring:message
								code="pm.changePassword.form.password.new.accesskey"
								var="newPasswordAccessKey" />
							<form:input path="newPassword" type="password" autocomplete="off"
								size="25" accesskey="${newPasswordAccessKey}" 
								cssClass="required" id="newPassword" style="width:92%;" />
							<form:errors path="newPassword" cssClass="error" />
						</p>
						
						
						<p>
							<label class="youpasswd" for="confirmNewPassword"><spring:message
									code="pm.changePassword.form.password.confirm" /></label>
							<spring:message
								code="pm.changePassword.form.password.confirm.accesskey"
								var="confimAccessKey" />
							<form:input path="confirmNewPassword" type="password"
								autocomplete="off" size="25" accesskey="${confirmAccessKey}"
								 cssClass="required" id="confirmNewPassword" style="width:92%;"/>
							<form:errors path="confirmNewPassword" cssClass="error" />
						</p>
										
						<p class="signin button">
							<input type="hidden" value="submitAnswer" name="_eventId" /> <input
								type="hidden" name="lt" value="${loginTicket}" /> <input
								type="hidden" name="execution" value="${flowExecutionKey}" /> <input
								type="submit"
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
				</div >
			</div>
			</div>
        </div>
