
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>
  
  <div id="msg" class="errors">
    <h2><spring:message code="screen.service.error.header" /></h2>
    <p>
    <c:if test="${not empty rootCauseException}">
    	<spring:message code="${rootCauseException}" />
    </c:if>
    </p>
  </div>

 