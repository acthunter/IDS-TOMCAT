

<%@ page pageEncoding="UTF-8"%>
<%@ page contentType="text/html; charset=UTF-8"%>
<%@ page import="java.util.Map"%>
<%@ page import="java.util.Iterator"%>
<%@ page import="org.jasig.cas.client.authentication.AttributePrincipal"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="spring" uri="http://www.springframework.org/tags"%>
<%@ taglib prefix="form" uri="http://www.springframework.org/tags/form"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions"%>

<link type="text/css" rel="stylesheet" href="<c:url value="/css/cas.css" />" />
<link rel="stylesheet" type="text/css" href="css/cform/demo.css" />
<link rel="stylesheet" type="text/css" href="css/cform/style2.css" />
<link rel="stylesheet" type="text/css" href="css/cform/cas17.css" />
<link rel="stylesheet" type="text/css"
	href="css/cform/animate-custom.css" />

<style type="text/css">
.appTitle {
	border: 1px solid #008c90;
	border-radius: 5px;
	font-size: 1.3em;
	margin: 10px;
	text-align: center;
}

.appBox img {
	width: auto;
	height: 70px;
	border: #008c90 2px solid;
	border-radius: 5px;
}

.centerDiv {
	margin: 50px 50px;
}
</style>
<div id="bniattrs" style="display: none">
	<c:forEach var="attr" items="${principal.attributes}"
		varStatus="loopStatus" begin="0"
		end="${fn:length(principal.attributes)}" step="1">
	
		<${fn:escapeXml(attr.key)}>${fn:escapeXml(attr.value)}</${fn:escapeXml(attr.key)}> 
	      </c:forEach>
</div>
<c:set var="isBlankMenu" value="${principal.attributes.idm}"/>
<div style="height:559px;">
<div class="centerDiv">
	
	<table border="0" id="listappFilter">

		<c:set var="isOpen" value="false"/>
		<c:set var="appsPerRow" value="8"/>
		<c:forEach var="apps" items="${clientViewRegister}" varStatus="cidx">
			
			<c:if test="${(cidx.index mod appsPerRow) == 0}">
				<tr>
				<c:set var="isOpen" value="true"/>
			</c:if>

			<td><c:choose>
					<c:when test="${apps.enabled}">
						<a href="${apps.href}">
							<div class="appBox">
								<img src="images/app/${apps.icon}" />
							</div>
							<div class="appTitle">${apps.displayName}</div>
						</a>
					</c:when>
					<c:otherwise>
						<div onclick="alert('not enabled');">
							<div class="appBox">
								<img src="images/app/${apps.icon}" />
							</div>
							<div class="appTitle">${apps.displayName}</div>
						</div>
					</c:otherwise>
				</c:choose></td>
			<c:if test="${(cidx.index mod appsPerRow) == appsPerRow - 1}">
				</tr>
				<c:set var="isOpen" value="false"/>
			</c:if>
		</c:forEach>
		<c:if test="${isOpen}">
			</tr>
		</c:if>
		<c:if test="${empty isBlankMenu}">
			<div style="height: 560px;">
					<div style="margin-top: 50px;">
						<div id="wrapper" style="width: 545px;">
							<div id="login" class="animate form">
								<h1
									style='<spring:message code="cas.notice.${noticeId}.style"/>'>
									<spring:message code="Kewenangan Aplikasi Belum Tersedia" />
								</h1>
								<br>
								
									<p style= "text-align: center";><spring:message code="Anda dapat memanfaatkan fitur <b>Reset Password</b>, yang terletak pada pojok kanan atas" /></li>
								</c:if>
						</div>
					</div>
				</div>
			</div>
	</table>
</div>
</div>