# Architecture Decision Records (ADR)

This document captures **key architectural decisions**, their context, and rationale.

The goal is to explain **why** certain choices were made, not just **what** was implemented.

---

## ADR-001: Use of Handlers Instead of Fat Controllers

**Status:** Accepted

### Context
Laravel encourages placing business logic inside controllers or models, which often leads to:
- large controllers
- tightly coupled domain and infrastructure
- poor testability

### Decision
All business logic is implemented in **Application layer Handlers**.
Controllers are kept thin and act only as delivery mechanisms.

### Consequences
- Clear separation of concerns
- Improved testability
- Slightly more boilerplate

---

## ADR-002: Transitional UseCaseExecutor

**Status:** Accepted (Transitional)

### Context
The application requires:
- audit logging
- context resolution (tenant / user)
- consistent execution flow
- centralized handling of cross-cutting concerns

Introducing full use-case objects upfront would add complexity too early.

### Decision
A shared `UseCaseExecutor` wraps handler execution and provides:
- execution boundaries
- logging
- context propagation

### Consequences
- Cross-cutting concerns handled centrally
- Architecture remains flexible
- Executor may evolve or be replaced by explicit use-case layer

---

## ADR-003: Repository and Query Separation

**Status:** Accepted

### Context
Mixing reads and writes in a single repository often leads to:
- unclear intent
- complex interfaces
- performance issues

### Decision
- Repositories handle **state changes**
- Queries handle **read models**

### Consequences
- Clear intent
- Easier optimization of read paths
- Slightly more classes

---

## ADR-004: Evolutionary Architecture Approach

**Status:** Accepted

### Context
Designing a “perfect” architecture upfront is unrealistic in real-world projects.

### Decision
The system is designed to **evolve in stages**, allowing:
- temporary abstractions
- controlled technical debt
- gradual refinement of domain boundaries

### Consequences
- Some architectural elements are transitional
- README and ADR explicitly document this evolution
- Reduced risk of overengineering

---

## ADR-005: Avoiding Framework Magic in Domain

**Status:** Accepted

### Context
Framework-specific behavior inside the domain layer:
- reduces portability
- hides business rules
- complicates testing

### Decision
The domain layer remains framework-agnostic.
Laravel is treated as an infrastructure and delivery mechanism.

### Consequences
- Cleaner domain model
- Easier refactoring
- More explicit mapping code
