<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>Benedict Etzel</title>
    <link rel="self" href="https://beheh.de" />
    <subtitle>Student an der Ostsee</subtitle>
    <updated>2015-07-21T16:08:01+02:00</updated>
    <generator>beheh.de</generator>
    <id>https://beheh.de</id>
{% for entry in entries %}
    <entry>
        <title type="html"><![CDATA[{{entry.title}}]]></title>
        <link href="https://beheh.de/{{entry.filename}}" />
        <id>https://beheh.de/{{entry.filename}}</id>
        <content type="html"><![CDATA[{{entry.contents|markdown}}]]></content>
        <updated>{{entry.timestamp}}</updated>
    </entry>{% endfor %}
</feed>