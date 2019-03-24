FROM python:alpine

RUN mkdir /srv

WORKDIR /usr/src/app

COPY ./main.py /usr/src/app/main.py
COPY ./all.py /usr/src/app/all.py
COPY ./categories.py /usr/src/app/categories.py
COPY ./post.py /usr/src/app/post.py
COPY ./posts.py /usr/src/app/posts.py
COPY ./settings.py /usr/src/app/settings.py
COPY ./requirements.txt /usr/src/app/requirements.txt

RUN pip install --no-cache-dir -r requirements.txt

python -m compileall /usr/src/app

rm -f /usr/src/app/requirements.txt

EXPOSE 5000

ENTRYPOINT ["python", "/usr/src/app/main.py"]
