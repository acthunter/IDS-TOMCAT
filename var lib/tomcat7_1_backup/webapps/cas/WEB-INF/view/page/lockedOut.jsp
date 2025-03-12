
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>
    <div id="msg" class="info">
        <h2><spring:message code="pm.lockedOut.header" /></h2>
        
        <p><spring:message code="pm.lockedOut.text" /></p>
        
        <br />
        
        <p><spring:message code="pm.lockedOut.exit-link.text" /></p>
    </div>

