
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>

<div id="msg" class="warn">
  <h2>Authentication Succeeded with Warnings</h2>

<c:forEach items="${messages}" var="message">
  cc<p class="message">${message.text}</p>
</c:forEach>

</div>

<c:url value="login" var="url">
  <c:param name="execution" value="${flowExecutionKey}" />
  <c:param name="_eventId" value="proceed" />
</c:url>

<div id="big-buttons">
 <a class="button" href="${url}">Continue</a>
</div>


