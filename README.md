# Multi-Tenant SaaS – Subscription & Orders API

> **Work in progress** backend project built for portfolio and recruitment purposes.  
> The project is intentionally incomplete and actively evolving.

This repository contains a **Multi-Tenant SaaS backend API** focused on **architecture, design decisions, and long-term maintainability**, rather than feature completeness.

The project serves as a **technical showcase** of how I design backend systems for complex domains.

---

## 🎯 Project Intent

The primary goal of this project is to demonstrate:

- how I **structure backend applications**
- how I approach **domain complexity**
- how I apply **Clean / Hexagonal Architecture principles**
- how I handle **cross-cutting concerns**
- how I think about **evolutionary architecture**

This is **not a CRUD demo** and **not a tutorial project**.

---

## 🧱 Architectural Overview

The codebase follows a layered structure inspired by **Hexagonal Architecture** and **DDD concepts**, while staying pragmatic and framework-aware.

```text
src/
├── Domain/
│ ├── Entities
│ ├── ValueObjects
│ ├── Enums
│ └── Interfaces
│
├── Application/
│ ├── Commands
│ ├── Queries
│ ├── Handlers
│ └── Common
│ └── UseCaseExecutor
│
├── Infrastructure/
│ ├── Persistence
│ ├── Repository Implementations
│ └── Query Implementations
│
├── Http/
│ └── Controllers
│
└── Tests/
   ├── Unit
   └── Feature
```

### Key Principles

- Thin controllers
- Explicit use case handlers
- Domain logic isolated from infrastructure
- Repositories and queries defined by interfaces
- No “fat models”
- Laravel used as a **delivery mechanism**, not as the core of the domain

---

## 🔁 Use Case Execution Model

Use cases are implemented as **explicit Handlers** in the Application layer.

Some handlers are executed through a shared **`UseCaseExecutor`**, which is responsible for handling **cross-cutting concerns**, such as:

- context resolution (tenant / user)
- audit logging
- execution boundaries
- consistency of use case execution

The executor is **not a separate use case layer**, but an **execution mechanism wrapping handlers**.

> This part of the architecture is intentionally evolving and will likely be refined as the project grows.

---

## 🧩 Implemented Modules (Current State)

- ✅ Multi-tenant foundation (`tenant_id` propagation)
- ✅ Orders (core structure)
- ✅ Order Items (partially aggregated)
- ✅ Subscriptions (basic lifecycle)
- ✅ Payments (early stage)
- ✅ Audit Logs (cross-cutting concern)
- ✅ Unit & feature tests
- ✅ SQLite persistence

---

## 🚧 Known Gaps & Planned Improvements

This project is **not feature-complete by design**.

### 🔐 Authentication & Authorization (Planned)
- No authentication layer yet
- Planned:
    - token-based authentication
    - tenant-aware authorization
    - role-based access control

### 🛒 Order & OrderItem Aggregation (In Progress)
- Aggregate boundaries are not finalized
- Planned:
    - stricter domain rules
    - clearer ownership of invariants
    - improved consistency guarantees

### 🔁 Subscriptions & Payments (Early Stage)
- Subscription lifecycle requires refinement
- Payment flow is incomplete
- Planned:
    - clearer state transitions
    - failure handling
    - retry and cancellation scenarios

### 🧪 Test Coverage
- Core scenarios covered
- Planned:
    - more edge cases
    - deeper domain-level tests

---

## 🛠️ Tech Stack

- **PHP 8.3**
- **Laravel 12**
- **SQLite**
- **Pest**
- **Composer**

The project intentionally avoids Docker and excessive tooling to keep the focus on **code and architecture**.

---

## 🧠 Design Philosophy (For Reviewers)

This project favors:

- clarity over cleverness
- explicit flow over framework magic
- long-term maintainability over short-term speed

Some architectural decisions are **deliberately transitional**, reflecting how real-world systems evolve rather than starting “perfect”.

---

## 🎯 Target Architecture (Planned)

The current architecture is intentionally transitional.  
Below is the **target direction**, not the current implementation.

### Planned Execution Flow

Controller
→ UseCaseExecutor
→ UseCase (Command / Query)
→ Handler
→ Domain
→ Repository / Query

### Planned Improvements

#### Explicit Use Case Layer
- Introduce explicit **UseCase objects** (Commands / Queries)
- Each use case will represent a single business intent
- Handlers will become thin orchestrators

#### Stronger Aggregate Boundaries
- Orders will become true aggregates
- OrderItems will be fully owned by Order
- Invariants enforced at aggregate root level

#### Authentication & Authorization
- Authentication as a delivery concern
- Authorization enforced at:
    - application layer (use cases)
    - optionally at domain boundaries

#### Context Handling
- Unified Request / Execution Context
- Tenant and user resolved once per request
- Context passed implicitly through executor

#### Cross-Cutting Concerns
- Logging
- Auditing
- Transactions
- Exception normalization

Handled centrally by `UseCaseExecutor`.

> The target architecture aims to balance **DDD purity** with **Laravel pragmatism**.

---

## 🧭 Roadmap

- [ ] Authentication & Authorization
- [ ] Finalize Order ↔ OrderItem aggregate
- [ ] Improve Subscription lifecycle
- [ ] Complete Payment flow
- [ ] Increase test coverage
- [ ] API documentation

---

## 📌 Final Notes

This repository represents a **snapshot of an evolving backend system**.

If you are reviewing this project as part of a recruitment process, please focus on:

- architectural decisions
- separation of concerns
- reasoning behind design choices
- readiness for future growth

Feature completeness is **intentionally not the main goal** at this stage.
