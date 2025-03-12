
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>



<link type="text/css" rel="stylesheet" href="<c:url value="/css/cas.css" />" />
<link rel="stylesheet" type="text/css" href="css/cform/demo.css" />
<link rel="stylesheet" type="text/css" href="css/cform/style2.css" />
<link rel="stylesheet" type="text/css" href="css/cform/cas17.css" />
<link rel="stylesheet" type="text/css"
	href="css/cform/animate-custom.css" />



<div style="height: 560px;">
	<div style="margin-top: 50px;">
		<div id="wrapper" style="width: 450px;">
			<div id="login" class="animate form">
				<h1>
					<spring:message code="pm.helpDesk.header" />
				</h1>
				<br>
				<ol>
				<c:choose>
					<c:when
						test="${not empty  flowRequestContext.messageContext.allMessages}">
						<h3>
							<c:forEach
								items="${flowRequestContext.messageContext.allMessages}"
								var="message">
								<p>
									<span class="infoText">${message.text}</span>
								</p>
							</c:forEach>
						</h3>
						<p>
						<div style="width: 300px;">${errorDetail}</div>
						</p>
					</c:when>
					<c:otherwise>
						<p>
							<spring:message code="pm.helpDesk.text" />
						</p>
					</c:otherwise>
				</c:choose>
				<br>
				<p>
		<a href="<c:url value="/login" />"><spring:message
				code="pm.helpDesk.exit-link.text" /></a>
	</p>
				</ol>

			</div>
		</div>
	</div>
</div>