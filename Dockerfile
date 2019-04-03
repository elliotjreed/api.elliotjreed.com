FROM python:alpine

RUN mkdir /usr/src/app

WORKDIR /usr/src/app

COPY ./main.py /usr/src/app/main.py
COPY ./all.py /usr/src/app/all.py
COPY ./all_full.py /usr/src/app/all_full.py
COPY ./categories.py /usr/src/app/categories.py
COPY ./post.py /usr/src/app/post.py
COPY ./posts.py /usr/src/app/posts.py
COPY ./requirements.txt /usr/src/app/requirements.txt

RUN apk add --update alpine-sdk --virtual build-dependencies && \
    pip install --no-cache-dir -r requirements.txt && \
    python -m compileall /usr/src/app && \
    rm -rf /usr/src/app/requirements.txt /var/cache/apk/* /tmp/* && \
    apk del build-dependencies

EXPOSE 5000

ENTRYPOINT ["python", "/usr/src/app/main.py"]
