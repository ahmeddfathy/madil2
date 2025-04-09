# System Patterns

## Architecture Overview
The system follows a modern Laravel-based architecture with clear separation of concerns:

1. Frontend Layer
   - Blade templates with optional Vue.js components
   - Tailwind CSS for styling
   - Responsive design patterns
   - Arabic language support

2. Backend Layer
   - Laravel MVC pattern
   - RESTful API endpoints
   - Service layer pattern
   - Repository pattern
   - Middleware for authentication and authorization

3. Data Layer
   - Eloquent ORM
   - Database migrations
   - Seeders and factories
   - MySQL database

## Design Patterns

### 1. Repository Pattern
- Abstracts database operations
- Centralizes data access logic
- Makes testing easier
- Provides consistent interface
- Example: ProductRepository, OrderRepository

### 2. Service Layer Pattern
- Business logic encapsulation
- Transaction management
- Complex operation handling
- Cross-cutting concerns
- Example: ProductService, CartService

### 3. Factory Pattern
- Object creation abstraction
- Test data generation
- Complex object construction
- Dependency injection
- Example: User, Product factories

### 4. Observer Pattern
- Event handling
- Real-time updates
- Notification system
- Audit logging
- Example: Order state changes, Notifications

### 5. Strategy Pattern
- Payment processing
- Report generation
- Export formats
- Authentication methods

## Component Relationships

### Core Modules
1. Authentication Module
   ```
   AuthController -> AuthService -> UserRepository
   ```
   - Uses Laravel Jetstream and Sanctum
   - Spatie Permission for roles and authorization

2. Inventory Module
   ```
   ProductController -> ProductService -> ProductRepository
   CategoryController -> CategoryService -> CategoryRepository
   ```
   - Products with variants (sizes, colors, quantities)
   - Categories for organization

3. Production Module
   ```
   ProductionController -> ProductionService -> WorkOrderRepository
   ```
   - Production planning and tracking
   - Status updates

4. Sales Module
   ```
   CartController -> CartService -> CartRepository
   OrderController -> OrderService -> OrderRepository
   ```
   - Shopping cart functionality
   - Order processing and tracking
   - Payment handling

## Data Flow Patterns
1. Request Flow
   ```
   HTTP Request -> Controller -> Service -> Repository -> Database
   ```

2. Response Flow
   ```
   Database -> Repository -> Service -> Controller -> HTTP Response/View
   ```

3. Event Flow
   ```
   Action -> Event -> Listeners -> Notifications/Actions
   ```

## Key Entity Relationships
1. User and Orders
   - One-to-Many: One user can have multiple orders

2. Product and Category
   - Many-to-One: Many products belong to one category

3. Product and Variants
   - One-to-Many: One product can have multiple sizes, colors, quantities

4. Order and Order Items
   - One-to-Many: One order contains multiple order items

5. Cart and Cart Items
   - One-to-Many: One cart contains multiple cart items

6. User and Roles
   - Many-to-Many: Users can have multiple roles

## Security Patterns
1. Authentication
   - Laravel Sanctum
   - Session management
   - Role-based access (Admin, Customer)
   - API authentication

2. Authorization
   - Spatie Permission package
   - Policy-based access control
   - Permission management
   - Resource protection
   - Action validation

3. Data Protection
   - Input validation
   - XSS prevention
   - CSRF protection
   - SQL injection prevention

## Testing Patterns
1. Unit Testing
   - Service layer tests
   - Repository tests
   - Model tests
   - Helper function tests

2. Feature Testing
   - API endpoint tests
   - Integration tests
   - Browser tests
   - Performance tests

3. Test Data Management
   - Factories
   - Seeders
   - Test fixtures
   - Mock data 
