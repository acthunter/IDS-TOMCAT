
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>

<link type="text/css" rel="stylesheet" href="<c:url value="/css/cas.css" />" />
<c:url var="loginUrl" value="/login">
    <c:if test="${not empty service}">
        <c:param name="service" value="${service}" />
    </c:if>
</c:url>

<div id="admin" class="useradmin">
   
        <h2><spring:message code="pm.setPassword.header" /></h2>

        <p class="note">
        <c:choose>
        <c:when test="${pmExtra eq 'wait'}">
            <spring:message code="pm.setPassword.wait" arguments="${loginUrl}" />
        </c:when>
        <c:otherwise>
            <spring:message code="pm.setPassword.text" arguments="${loginUrl}" />            
        </c:otherwise>
        </c:choose>        
        </p>
            
</div>


