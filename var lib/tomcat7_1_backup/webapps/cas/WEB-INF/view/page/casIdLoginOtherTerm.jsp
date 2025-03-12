
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/fmt" prefix="fmt" %>

  <div id="msg" class="errors">
    <h2><spring:message code="screen.badworkstation.heading" /></h2>
    <fmt:formatDate value="${jsessionControl.time}" pattern="dd-MM-yy hh:mm" var="jsactionTime"/>
    <p><spring:message code="error.session.control.userid_from_other_ip" 
    arguments="${jsessionControl.userid},${jsessionControl.clientIP}, ${jsactionTime}"/></p>
  </div>

