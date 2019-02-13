FROM docker.elastic.co/elasticsearch/elasticsearch-oss:6.6.0

RUN bin/elasticsearch-plugin install analysis-kuromoji && \
	bin/elasticsearch-plugin install analysis-icu && \
	bin/elasticsearch-plugin install analysis-smartcn
