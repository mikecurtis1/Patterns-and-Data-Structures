<?xml version="1.0"?>
<xsl:stylesheet 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
    version="1.0">
<xsl:output method="html"/>

<xsl:template match="text()|@*">
    <xsl:apply-templates/>
</xsl:template>

<xsl:template match="ead">
    <html>
        <head>
            <title><xsl:value-of select="//titlestmt/titleproper"/></title>
            <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
            <script src="generic.js" type="text/javascript"></script>
            <meta name="viewport" content="width=device-width, initial-scale=1" />
            <link rel="stylesheet" type="text/css" href="generic.css" media="screen"/>
            <link 
                rel="stylesheet" 
                type="text/css" 
                href="http://fonts.googleapis.com/css?family=Raleway|Josefin+Slab" />
        </head>
        <body>
            <h1><xsl:value-of select="//titlestmt/titleproper"/></h1>
            <div class="abstract">
                <xsl:value-of select="//archdesc/did/abstract"/>
            </div>
            <xsl:apply-templates/>
        </body>
    </html>
</xsl:template>

<xsl:template match="*">
    <div>
        <xsl:attribute name="class">
            <xsl:value-of select="name(.)"/>
        </xsl:attribute>
        <!--<xsl:if test="string-length(normalize-space(text()))>0"></xsl:if>-->
            <!-- head,div,lb,p,item -->
            <xsl:if test="name(.)!='head' and name(.)!='div' and name(.)!='lb' and name(.)!='p' and name(.)!='item'">
                <label><xsl:value-of select="name(.)"/>:</label>
            </xsl:if>
            <xsl:if test="count(./*)>0">
                <div class="toggle">&#9660;</div>
            </xsl:if>
        <xsl:value-of select="text()"/>
        <xsl:apply-templates/>
    </div>
</xsl:template>

</xsl:stylesheet>
