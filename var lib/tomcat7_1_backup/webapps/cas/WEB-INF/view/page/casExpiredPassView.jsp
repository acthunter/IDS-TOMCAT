<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>

<link type="text/css" rel="stylesheet"
	href="<c:url value="/css/cas.css" />" />
<link rel="stylesheet" type="text/css" href="css/cform/demo.css" />
<link rel="stylesheet" type="text/css" href="css/cform/style2.css" />
<link rel="stylesheet" type="text/css" href="css/cform/cas17.css" />
<link rel="stylesheet" type="text/css"
	href="css/cform/animate-custom.css" />
	
<div id="bniattrs" style="display: block">
	<c:forEach var="attr" items="${principal.attributes}"
		varStatus="loopStatus" begin="0"
		end="${fn:length(principal.attributes)}" step="1">
	
		<${fn:escapeXml(attr.key)}>${fn:escapeXml(attr.value)}</${fn:escapeXml(attr.key)}> 
	      </c:forEach>
</div>
  <%-- <div id="msg" class="errors">
    <h2><spring:message code="screen.expiredpass.heading" /></h2>
    <p><spring:message code="screen.expiredpass.message" arguments="${passwordPolicyUrl}" /></p>
  </div> --%>

<div style="height: 560px;">
	<div style="margin-top: 50px;">
		<div id="wrapper" style="width: 450px;">
			<div id="login" class="animate form">
				<h1  >
					<spring:message code="screen.expiredpass.heading_ind" />
				</h1>
				<br>
				<ol class="square">
					<li><spring:message code="screen.expiredpass.message_ind" /></li>
				</ol>
			</div>
		</div>
	</div>
</div>
