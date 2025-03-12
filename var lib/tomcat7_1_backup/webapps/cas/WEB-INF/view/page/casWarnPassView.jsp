
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>

<c:set var="ticketArg" value="${serviceTicketId}" scope="page" />
<c:if test="${fn:length(ticketArg) > 0}">
	<c:set var="ticketArg" value="ticket=${serviceTicketId}" />
</c:if>
<c:url var="changePasswordUrl" value="/login">
	<c:param name="execution" value="${flowExecutionKey}" />
	<c:param name="_eventId" value="changePassword" />
</c:url>
<c:url var="ignoreUrl" value="/login">
	<c:param name="execution" value="${flowExecutionKey}" />
	<c:param name="_eventId" value="ignore" />
</c:url>

<c:set var="forceAction" value="" />
<div class="errors">
	
	<p> 
		<c:if test="${expireHours lt 12}">
			<h2>
				<c:set var="forceAction" value="changePassword" />
				<spring:message code="screen.warnpass.heading.today" />
			</h2>
		</c:if>
		<c:if test="${expireHours lt 36 && expireHours gt 12}">
			<h2>
				<spring:message code="screen.warnpass.heading.tomorrow" />
			</h2>
		</c:if>
		<c:if test="${expireHours ge 36}">
			<h2>
				<spring:message code="screen.warnpass.heading.other"
					arguments="${expireHours/24}" />
			</h2>
		</c:if>
	</p>





	<c:if test="${not empty actionRequired}">
		<c:forEach items="${actionRequired.asMap()}" var="entry">
			<c:choose>
				<c:when test="${entry.value=='weak_password'}">
					<c:set var="forceAction" value="changePassword" />
					<spring:message code="screen.warnpass.message.weak_password" />
				</c:when>
<%-- 				<c:otherwise> --%>
<%-- 					 ${entry.value}<br> --%>
<%-- 				</c:otherwise> --%>
			</c:choose>
		</c:forEach>
	</c:if>


	<c:choose>
		<c:when test="${not empty forceAction}">
			<p>
				
			</p>
		</c:when>
		<c:otherwise>
			<c:choose>
				<c:when test="${empty passwordPolicyUrl}">
					<p>
						<spring:message code="screen.warnpass.message.line1"
							arguments="${changePasswordUrl}" />
					</p>
					<p>
						<spring:message code="screen.warnpass.message.line2"
							arguments="${ignoreUrl}" />
					</p>
				</c:when>

				<c:otherwise>
					<p>
						<spring:message code="screen.warnpass.message.line1"
							arguments="${passwordPolicyUrl}" />
					</p>
					<p>
						<spring:message code="screen.warnpass.message.line2"
							arguments="${fn:escapeXml(param.service)}${fn:indexOf(param.service, '?') eq -1 ? '?' : '&'}${ticketArg}" />
					</p>
				</c:otherwise>
			</c:choose>
		</c:otherwise>
	</c:choose>
 

</div>
<script type="text/javascript">
	var defURL= "/cas/login";
	var changepasswordURL = defURL + "?fname=cpwd";
	var forceAction=${not empty forceAction};
	
	var finalURL = forceAction ? changepasswordURL : defURL ;
	
	function redirectTo() {
		window.location = finalURL;
	}
	setTimeout( redirectTo,	10000);
</script>
