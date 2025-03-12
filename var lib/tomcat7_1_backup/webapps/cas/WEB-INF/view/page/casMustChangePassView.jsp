
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>
  <div id="msg" class="errors">
    <h2><spring:message code="screen.mustchangepass.heading" /></h2>
    <p><spring:message code="screen.mustchangepass.message" arguments="${passwordPolicyUrl}"  /></p>
  </div>
