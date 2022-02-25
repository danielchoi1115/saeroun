FROM python:3.10.2-slim-bullseye

ENV PYTHONUNBUFFERED=0

ADD . .

EXPOSE 5000

RUN pip install -r ./requirements.txt

CMD ["python", "./saeroun-api.py"]