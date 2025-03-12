
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/fmt" prefix="fmt" %>

  <div id="msg" class="errors">
  	 <fmt:formatDate value="${jsessionControl.time}" pattern="dd-MM-yy hh:mm" var="jsactionTime"/>
    <h2><spring:message code="screen.badworkstation.heading" /></h2>
    <p><spring:message code="error.session.control.ip_used_for_other_userid" arguments="${jsessionControl.clientIP},${jsessionControl.userid},${jsactionTime}" /></p>
  </div>

