<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>


 <div id="msg" class="errors"style="background:none;padding-top:30px;">
	<c:choose>
		<c:when test="${casErrorType =='credentialExpired'}">
			<c:set var="dspUnit" value="${expireHours gt 0 ? expireHours : -expireHours}"/>
			 <c:choose>
			 	<c:when test="${dspUnit lt 24}">
			 		<c:set var="expireText" value="${dspUnit} hours"/>
			 	</c:when> 
			 	<c:otherwise>
			 		<c:set var="expireText" value="${fn:substringBefore(dspUnit/24, '.')} days"/>
			 	</c:otherwise>
			 </c:choose>
			 <h2><spring:message code="screen.expiredpass.heading" arguments="${expireText} "/></h2>
   			 <p><a href="#" onclick="createSubmit('forgotPassword');"><spring:message code="screen.expiredpass.reset.message"/></a></p>
		</c:when>
		<c:otherwise>
			<c:forEach var="entry" items="${casErrorType.handlerErrors}">
  				<c:out value="${entry.key} - ${entry.value}"/>
  				<c:out value=""/>
			</c:forEach>
		</c:otherwise>
	</c:choose>
</div>