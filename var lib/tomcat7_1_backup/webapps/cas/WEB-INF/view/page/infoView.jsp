
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>

<link type="text/css" rel="stylesheet"
	href="<c:url value="/css/cas.css" />" />
<c:url var="continueUrl" value="login">
	<c:param name="_eventId" value="continue" />
	<c:param name="execution" value="${flowExecutionKey}" />
</c:url>

<div id="admin" class="useradmin"  style="height:610px">

	<h2>
		<spring:message code="pm.changedPassword.header" />
	</h2>

	
	<p class="note">
		<c:choose>
			<c:when test="${msgType eq 'general'}">
				
				<spring:message code="${msgKey}" />
			</c:when>
			<c:otherwise>
				<spring:message code="pm.changedPassword.text"
					arguments="${continueUrl}" />
			</c:otherwise>
		</c:choose>
	</p>

</div>
