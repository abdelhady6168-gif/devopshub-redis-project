# DevOpsHub Feedback System

Midterm project for Cloud Computing and DevOps Engineering.

- App 1: Message Collector (form + visit counter)
- App 2: Dashboard (shows total messages and visits)
- Redis: shared database



---------------------------------------------------------------

## How to run
1. Install Docker Desktop and start it
2. `docker compose up -d --build`
3. App 1 (Message Collector): http://localhost:8081
4. App 2 (Dashboard): http://localhost:8082
5. Stop: `docker compose down` (data is kept in the redis_data volume)